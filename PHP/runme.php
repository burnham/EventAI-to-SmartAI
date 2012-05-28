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

# Debug - limit to 50 for developping purposes
$EAIDataSet = $pdo->query("SELECT * FROM creature_ai_scripts ORDER BY id LIMIT 500");

# Create files
$sqlOutputSAIs = fopen('./eai2sai' . ($withDate ? '-' . date() : '')  . '.sql', 'a');
$textsOutput   = fopen('./eai2saiTexts-' . ($withDate ? '-' . date() : '')  . '.sql', 'a');

writeToFile($textsOutput, "-- Deleting all entries from creature_ai_texts");
writeToFile($textsOutput, "TRUNCATE TABLE `creature_ai_texts`;");

$NPC_NAME        = ""; // Save the last iterated NPC name
$NPC_ID          = 0;   // And its entry in the table.
$currentRowIndex = 0;
$usedEventData   = array(); // Used to detect linking

while ($eaiItem = $EAIDataSet->fetch(PDO::FETCH_OBJ)) {
    // Prevent calling the NPC's name on each iteration
    if ($NPC_ID != $eaiItem->creature_id) {
        $NPC_NAME  = $pdo->query('SELECT name FROM creature_template WHERE entry = ' . $eaiItem->creature_id)->fetch(PDO::FETCH_OBJ)->name;
        $NPC_ID   = $eaiItem->creature_id;
    }
    
    writeToFile($sqlOutputSAIs, '-- ' . $NPC_NAME . ' SAI');
    writeToFile($sqlOutputSAIs, 'SET @ENTRY := ' . $NPC_ID . ';');
    writeToFile($sqlOutputSAIs, 'UPDATE `creature_template` SET `AIName`="SmartAI" WHERE `entry`=@ENTRY;');
    writeToFile($sqlOutputSAIs, 'DELETE FROM `creature_ai_scripts` WHERE `creature_id`=@ENTRY;');
    writeToFile($sqlOutputSAIs, 'DELETE FROM `smart_scripts` WHERE `entryorguid`=@ENTRY AND `source_type`=0;');
    
    # Onwards to the fucking hardcore part
    $data = array();
    $data['entryorguid']  = '@ENTRY';
    $data['source_type']  = 0;
    $data['id']           = $currentRowIndex++;
    $data['link']         = 0; // Will be changed afterwards if another event uses the same parameters!
    $data['event_type']   = $eaiItem->event_type;

    $data['event_phase_mask'] = 0;
    for ($phase = 32; $phase > 0; $phase /= 2) // If it does not work, blame Horn (Not willing to brain too much about those bitmasks shit)
        if (!($phase & $eaiItem->event_inverse_phase_mask))
            $data['event_phase_mask'] |= $phase;
    
    $data['event_chance'] = $eaiItem->event_chance;
    $data['event_flags']  = SAI2EAIFlag($eaiItem->event_flags);
    
    
    $textsParsed = false;
    # Parsing actions here
    for ($i = 1; $i < 4; $i++) {
        $currentAction = $eaiItem->{'action' . $i . '_type'};
        $param1 = $eaiItem->{'action' . $i . '_param1'};
        $param2 = $eaiItem->{'action' . $i . '_param2'};
        $param3 = $eaiItem->{'action' . $i . '_param3'};
        
        switch ($currentAction)
        {
            case ACTION_T_TEXT:
            {
                if ($textsParsed) // Avoid reading texts on every talk action
                    break;
                    
                //! We are going to assign groupIDs and textIDs here
                $npcTexts1 = parseTexts($pdo, $textsOutput, $NPC_ID, $NPC_NAME, $param1);
                $npcTexts2 = parseTexts($pdo, $textsOutput, $NPC_ID, $NPC_NAME, $param2);
                $npcTexts3 = parseTexts($pdo, $textsOutput, $NPC_ID, $NPC_NAME, $param3);
                
                $textsParsed = true;
            }
            default:
                break;
        }
    }
}