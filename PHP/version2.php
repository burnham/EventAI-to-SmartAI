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
$EAIDataSet = $pdo->query("SELECT * FROM creature_ai_scripts ORDER BY id");

ob_start();
echo '>> Gotten all entries in ' . round(microtime(true) - $oldDate, 4) . ' ms' . PHP_EOL;
echo PHP_EOL . 'Grouping entries by NPC ...' . PHP_EOL;
ob_end_flush();

# Create files
$sqlOutputSAIs = fopen('./eai2sai.sql', 'a');

$npcName         = "";  // Save the last iterated NPC name
$npcId           = 0;   // And its entry in the table.

$npcStore        = array();

$oldDate = microtime(true);

while ($eaiItem = $EAIDataSet->fetch(PDO::FETCH_OBJ)) {
    // Prevent calling the NPC's name on each iteration
    if ($npcName != $eaiItem->creature_id) {
        $npcName   = $pdo->query('SELECT name FROM creature_template WHERE entry = ' . $eaiItem->creature_id)->fetch(PDO::FETCH_OBJ)->name;
        $npcId     = $eaiItem->creature_id;
        $npcStore[$npcId] = new NPC($pdo, $npcId, $npcName);
    }
    
    $eaiItem->npcName = $npcName;
    $eaiItem->npcId   = $npcId;
    $npcStore[$npcId]->addEAI($eaiItem);
}

ob_start();
echo '>> ' . count($npcStore) . ' different NPC EAIs grouped in ' . round(microtime(true) - $oldDate, 4) . ' ms !' . PHP_EOL;
ob_end_flush();

foreach ($npcStore as $npcId => $npcObj) {
    $npcObj->convertAllToSAI();
    echo $npcObj->getSmartScripts();
    sLog::outSpecificFile('creature_texts.sql', $npcObj->getCreatureText());
    //die;
}
