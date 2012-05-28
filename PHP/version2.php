<?php

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

$host = 'localhost';
$dbName = '335_world';
$username = 'root';
$password = '';
$withDate = false; // Append date to filename ?

require_once('./utils.php');

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
$sqlOutputSAIs = fopen('./eai2sai' . ($withDate ? '-' . date() : '')  . '.sql', 'a');
$textsOutput   = fopen('./eai2saiTexts' . ($withDate ? '-' . date() : '')  . '.sql', 'a');

$NPC_NAME        = "";  // Save the last iterated NPC name
$NPC_ID          = 0;   // And its entry in the table.
$currentRowIndex = 0;
$usedEventData   = array(); // Used to detect linking

$npcStore        = array();

$oldDate = microtime(true);

while ($eaiItem = $EAIDataSet->fetch(PDO::FETCH_OBJ)) {
    // Prevent calling the NPC's name on each iteration
    if ($NPC_ID != $eaiItem->creature_id) {
        $npcName   = $pdo->query('SELECT name FROM creature_template WHERE entry = ' . $eaiItem->creature_id)->fetch(PDO::FETCH_OBJ)->name;
        $npcId     = $eaiItem->creature_id;
        $npcStore[$npcId] = new NPC($pdo, $npcId);
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
    echo $npcObj->toSQL();
    die;
}
