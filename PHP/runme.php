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

$EAIDataSet = $pdo->query("SELECT * FROM creature_ai_scripts ORDER BY id");

# Create files
$sqlOutputSAIs = fopen('./eai2sai' . ($withDate ? '-' . date() : '')  . '.sql', 'a');
$textsOutput   = fopen('./eai2saiTexts-' . ($withDate ? '-' . date() : '')  . '.sql', 'a');

writeToFile($textsOutput, "-- Deleting all entries from creature_ai_texts");
writeToFile($textsOutput, "TRUNCATE TABLE `creature_ai_texts`;");

$currentNpcName  = ""; // Save the last iterated NPC name
$previousNpcId   = 0;   // And its index in the table.
$currentRowIndex = 0;
$usedEventData   = array(); // Used to detect linking

while ($eaiItem = $EAIDataSet->fetch(PDO::FETCH_OBJ)) {
    // Prevent calling the NPC's name on each iteration
    if ($previousNpcId != $eaiItem->creature_id) {
        $currentNpcName  = $pdo->query('SELECT name FROM creature_template WHERE entry = ' . $eaiItem->creature_id)->fetch(PDO::FETCH_OBJ)->name;
        $previousNpcId   = $eaiItem->creature_id;
        $currentRowIndex = 0;
        $usedEventData   = array();
    }
    
    writeToFile($sqlOutputSAIs, '-- ' . $currentNpcName . ' SAI');
    writeToFile($sqlOutputSAIs, 'SET @ENTRY := ' . $previousNpcId . ';');
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
    
    // Thanks Horn for this.
    switch ($data['event_type'])
    {
        case EVENT_T_HP:
        case EVENT_T_MANA:
        case EVENT_T_TARGET_HP:
            $data['event_param1'] = $eaiItem->event_param2;
            $data['event_param2'] = $eaiItem->event_param1;
            $data['event_param3'] = $eaiItem->event_param3;
            $data['event_param4'] = $eaiItem->event_param4;
            break;
        case EVENT_T_FRIENDLY_HP:
            $data['event_param1'] = 0;
            $data['event_param2'] = $eaiItem->event_param2;
            $data['event_param3'] = $eaiItem->event_param3;
            $data['event_param4'] = $eaiItem->event_param4;
            break;
        case EVENT_T_RECEIVE_EMOTE: // SAI'S SMART_EVENT_RECEIVE_EMOTE doesn't have the same structure at all. Fixme!
            $data['event_param1'] = $eaiItem->event_param1;
            $data['event_param2'] = 1000;
            $data['event_param3'] = 1000;
            $data['event_param4'] = 0;
            break;
        default:
            $data['event_param1'] = $eaiItem->event_param1;
            $data['event_param2'] = $eaiItem->event_param2;
            $data['event_param3'] = $eaiItem->event_param3;
            $data['event_param4'] = $eaiItem->event_param4;
            break;            
    }
    
    # Parse texts
    $creatureAITexts = $pdo->query("SELECT * FROM creature_ai_texts WHERE entry IN (${param1}, ${param2}, ${param3})");
    $textId = 0;
    $groupId = 0;
    $creatureTexts = array();
    
    writeToFile($textsOutput, '-- Texts for NPC ' . $previousNpcId . ' - ' . $currentNpcName);
    writeToFile($textsOutput, 'SET @ENTRY := ' . $previousNpcId . ';');
    writeToFile($textsOutput, 'DELETE FROM `creature_text` WHERE `entry`=' . $previousNpcId . ';');
    
    while ($creatureText = $creatureAITexts->fetch(PDO::FETCH_OBJ)) {
        $creatureTexts[$textId++] = array();
        $creatureTexts[$textId]['entry']    = '@ENTRY';
        $creatureTexts[$textId]['id']       = $textId;
        $creatureTexts[$textId]['groupid']  = $groupId;
        $creatureTexts[$textId]['sound']    = $creatureText->sound;
        $creatureTexts[$textId]['comment']  = $creatureText->comment;
        $creatureTexts[$textId]['emote']    = $creatureText->emote;
        $creatureTexts[$textId]['language'] = $creatureText->language;
        $creatureTexts[$textId]['probability'] = 100;
        $creatureTexts[$textId]['duration'] = 0;

        switch ($creatureText->type)
        {
            case 0:
            case 1:
            case 2:
                $creatureTexts[$textId]['type'] = 12 + $creatureText->type * 2;
                break;
            case 3:
                $creatureTexts[$textId]['type'] = 41;
                break;
            case 4:
                $creatureTexts[$textId]['type'] = 15;
                break;
            case 5:
                $creatureTexts[$textId]['type'] = 42; // YOU WIN
                break;
            case 6:
                // @Horn: Why this ?
                if ($creatureText->entry == -544)
                    $creatureTexts[$textId]['type'] = 16;
                else if ($creatureText->entry == -860)
                    $creatureTexts[$textId]['type'] = 12;
                break;
        }
        
        writeCreatureText($creatureTexts[$textId], $textId, $creatureAITexts->rowCount(), $textsOutput);
    }
    
    # Parsing actions here
    for ($i = 1; $i <= 4; $i++) {
        $currentAction = $eaiItem->{'action' . $i . '_type'};
        $param1 = $eaiItem->{'action' . $i . '_param1'};
        $param2 = $eaiItem->{'action' . $i . '_param2'};
        $param3 = $eaiItem->{'action' . $i . '_param3'};
        $param4 = $eaiItem->{'action' . $i . '_param4'};
        
        switch ($currentAction)
        {
            case ACTION_T_TEXT:
            {
                
            }
            default:
                break;
        }
    }
}