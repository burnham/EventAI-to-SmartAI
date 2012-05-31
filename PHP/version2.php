<?php

$host = 'localhost';
$dbName = '335_world';
$username = 'root';
$password = '';

require_once('./utils.php');

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

try {
    $pdoOptions[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
    $pdo = new PDO('mysql:host=' . $host . ';dbname=' . $dbName, $username, $password, $pdoOptions);
} catch (Exception $e) {
    die("Error while connecting to the database. Message sent by PDO: " . $e->getMessage());
}

ob_start();
echo PHP_EOL . 'Selecting all EventAIs from the database ...' . PHP_EOL;
ob_end_flush();

$oldDate = microtime(true);
# Debug - limit to 500 for developping purposes
$EAIDataSet = $pdo->query("SELECT * FROM creature_ai_scripts ORDER BY id")->fetchAll(PDO::FETCH_OBJ);

ob_start();
echo '>> Gotten ' . count($EAIDataSet) . ' entries in ' . round(microtime(true) - $oldDate, 4) . ' ms' . PHP_EOL;
echo PHP_EOL . 'Grouping entries by NPC ...' . PHP_EOL;
ob_end_flush();

# Create files
$sqlOutputSAIs = fopen('./eai2sai.sql', 'a');

$npcName         = "";  // Save the last iterated NPC name
$npcId           = 0;   // And its entry in the table.

$npcStore        = array();

$oldDate = microtime(true);

foreach ($EAIDataSet as $eaiItem) {
    // Prevent calling the NPC's name on each iteration
    if ($npcId != $eaiItem->creature_id) {
        $npcName   = $pdo->query('SELECT name FROM creature_template WHERE entry = ' . $eaiItem->creature_id)->fetch(PDO::FETCH_OBJ)->name;
        $npcId     = $eaiItem->creature_id;
        $npcStore[$npcId] = new NPC($pdo, $npcId, $npcName);
    }
    
    $eaiItem->npcName = $npcName;
    $eaiItem->npcId   = $npcId;
    $npcStore[$npcId]->addEAI($eaiItem);
}

unset($eaiItem, $npcName, $npcId, $EAIDataSet); // Save some memory

$storeSize = count($npcStore);

ob_start();
echo '>> ' . $storeSize . ' different NPC EAIs detected in ' . round(microtime(true) - $oldDate, 4) . ' ms !' . PHP_EOL . PHP_EOL;
echo 'Converting ... (  0%)' . PHP_EOL;
ob_end_flush();

if (file_exists('creature_texts_v2.sql'))
    unlink('creature_texts_v2.sql');
if (file_exists('smart_scripts_v2.sql'))
    unlink('smart_scripts_v2.sql');

$itr = 0;
foreach ($npcStore as $npcId => $npcObj) {
    // echo $npcObj->countSQLRows() . ' EAI sql row found for NPC ' . $npcObj->npcName . PHP_EOL;

    $npcObj->convertAllToSAI();
    $npcObj->getSmartScripts(false); // Dump texts ONLY

    sLog::outSpecificFile('creature_texts_v2.sql', $npcObj->getCreatureText());
    sLog::outSpecificFile('smart_scripts_v2.sql', $npcObj->getSmartScripts());
   
    $pct = ++$itr * 100 / $storeSize;
    if (is_int($pct / 5)) {
        ob_start();
        //echo ' ' . $npcObj->npcName . ' (Entry #' . $npcObj->npcId . ') successfully converted to SAI!' . PHP_EOL;
        if ($pct != 100)
            printf('Converting ... (%3.3d%%)' . PHP_EOL, $pct);
        else echo 'Done!' . PHP_EOL;
        ob_end_flush();
    }
}
