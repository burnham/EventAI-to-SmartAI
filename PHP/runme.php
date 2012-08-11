<?php
ini_set('memory_limit', "148M"); // That shouldnt be a problem, default is 128MB and the script peakes at around 140Mb.

require_once('./utils.php');
require_once('./factory.php');

# ############# DO NOT EDIT PAST THIS LINE, UNLESS YOU KNOW WHAT YOU ARE DOING ############# #

// Cosmetic useless shit at different places here
ob_start();
echo PHP_EOL . " ______                       __" . PHP_EOL;
echo "/\\__  _\\       __          __/\\ \\__" . PHP_EOL;
echo "\\/_/\\ \\/ _ __ /\\_\\    ___ /\\_\\ \\, _\\  __  __" . PHP_EOL;
echo "   \\ \\ \\/\\`'__\\/\\ \\ /' _ `\\/\\ \\ \\ \\/ /\\ \\/\\ \\" . PHP_EOL;
echo "    \\ \\ \\ \\ \\/ \\ \\ \\/\\ \\/\\ \\ \\ \\ \\ \\_\\ \\ \\_\\ \\" . PHP_EOL;
echo "     \\ \\_\\ \\_\\  \\ \\_\\ \\_\\ \\_\\ \\_\\ \\__\\\\/`____ \\" . PHP_EOL;
echo "      \\/_/\\/_/   \\/_/\\/_/\\/_/\\/_/\\/__/ `/___/> \\" . PHP_EOL;
echo "                                 C O R E  /\\___/" . PHP_EOL;
echo "http://TrinityCore.org                    \\/__/\n" . PHP_EOL;
ob_end_flush();


if ($iniFile = parse_ini_file('config.ini')) {
    Factory::setDbData($iniFile['hostname'], $iniFile['userName'], $iniFile['password'], $iniFile['worldDatabase']);

    echo '>> Config file found and parsed sucessfully.' . PHP_EOL;

    $dumpSpellNames = (isset($iniFile['dumpSpellNames']) && $iniFile['dumpSpellNames'] == 1);
    if ($dumpSpellNames)
        echo PHP_EOL . '>> Spell.dbc will be parsed.' . PHP_EOL;
    Factory::toggleDbcWorker($dumpSpellNames);
}

ob_start();
echo PHP_EOL . 'Selecting all EventAIs from the database ...' . PHP_EOL;
ob_end_flush();

$oldDate = microtime(true);
$EAIDataSet = Factory::createOrGetDBHandler()->query("SELECT * FROM creature_ai_scripts ORDER BY id")->fetchAll(PDO::FETCH_OBJ);

ob_start();
echo '>> Gotten ' . count($EAIDataSet) . ' entries in ' . round(microtime(true) - $oldDate, 4) . ' ms' . PHP_EOL;
echo PHP_EOL . 'Grouping entries by NPC ...' . PHP_EOL;
ob_end_flush();

$npcName   = "";  // Save the last iterated NPC name
$npcId     = 0;   // And its entry in the table.

$npcStore  = array();

$oldDate   = microtime(true);

foreach ($EAIDataSet as $eaiItem) {
    if ($npcId != $eaiItem->creature_id) {
        # New NPC. Create a corresponding NPC class instance.
        $npcName   = Factory::createOrGetDBHandler()->query('SELECT name FROM creature_template WHERE entry = ' . $eaiItem->creature_id)->fetch(PDO::FETCH_OBJ)->name;
        $npcId     = $eaiItem->creature_id;
        $npcStore[$npcId] = new NPC($npcId, $npcName);
    }

    $eaiItem->npcName = $npcName;
    $eaiItem->npcId   = $npcId;
    $npcStore[$npcId]->addEAI($eaiItem);
}

unset($eaiItem, $npcName, $npcId, $EAIDataSet); // Save some memory

$storeSize = count($npcStore);

# Delete previous files
if (file_exists('creature_texts_v2.sql'))
    unlink('creature_texts_v2.sql');

if (file_exists('smart_scripts_v2.sql'))
    unlink('smart_scripts_v2.sql');

ob_start();
echo '>> ' . $storeSize . ' different NPC EAIs detected in ' . round(microtime(true) - $oldDate, 4) . ' ms !' . PHP_EOL . PHP_EOL;
printf('Converting [%3.3d%%] ', 0);
ob_end_flush();

$itr = 0;
$oldDate = microtime(true);
foreach ($npcStore as $npcId => $npcObj) {
    $npcObj->convertAllToSAI();
    $npcObj->getSmartScripts(false); // Dump texts ONLY

    // The order is important here, CreatureText changes data on the parent, thus on all the current NPC's SAI.
    sLog::outSpecificFile('creature_texts_v2.sql', $npcObj->getCreatureText());
    sLog::outSpecificFile('smart_scripts_v2.sql', $npcObj->getSmartScripts());
    
    // Free memory on the fly
    unset($npcStore[$npcId], $npcId, $npcObj);

    ob_start();
    $pct = (++$itr) * 100 / $storeSize;
    if (is_int($pct / 5))
        printf(PHP_EOL . 'Converting [%3.3d%%] ', $pct);
    ob_end_flush();
}

unset($pct, $itr, $npcObj, $npcId, $npcStore);

echo PHP_EOL . 'Finished parsing data in ' . round(microtime(true) - $oldDate, 4) . ' ms!' . PHP_EOL;

unset($oldDate);
