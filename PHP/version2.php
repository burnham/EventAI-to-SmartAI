<?php

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

# Debug - limit to 500 for developping purposes
$EAIDataSet = $pdo->query("SELECT * FROM creature_ai_scripts ORDER BY id LIMIT 500");

# Create files
$sqlOutputSAIs = fopen('./eai2sai' . ($withDate ? '-' . date() : '')  . '.sql', 'a');
$textsOutput   = fopen('./eai2saiTexts' . ($withDate ? '-' . date() : '')  . '.sql', 'a');

$NPC_NAME        = "";  // Save the last iterated NPC name
$NPC_ID          = 0;   // And its entry in the table.
$currentRowIndex = 0;
$usedEventData   = array(); // Used to detect linking

$SAIStore = new SAICollection();
$EAIStore = array();

while ($eaiItem = $EAIDataSet->fetch(PDO::FETCH_OBJ)) {
    // Prevent calling the NPC's name on each iteration
    if ($NPC_ID != $eaiItem->creature_id) {
        $NPC_NAME  = $pdo->query('SELECT name FROM creature_template WHERE entry = ' . $eaiItem->creature_id)->fetch(PDO::FETCH_OBJ)->name;
        $NPC_ID    = $eaiItem->creature_id;
        $EAIStore[$NPC_ID] = new EAICollection();
    }
    
    $eaiItem->npcName = $NPC_NAME;
    $eaiItem->npcId   = $NPC_ID;
    $EAIStore[$NPC_ID]->additem($eaiItem);
}

echo $EAIDataSet->rowCount() . ' EAI entries stored and ready for processing !';

foreach ($EAIStore as $idx => $eai) {
    $eai->toSAI($pdo);
    
    die;
}
