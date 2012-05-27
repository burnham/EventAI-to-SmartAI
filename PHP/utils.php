<?php
require_once('./sqlbuilder.class.php');
require_once('./eai.def.php');
require_once('./sai.def.php');

class Utils
{
    /* boolean */ static function hasParameters($eventId) {
        switch ($eventId)
        {
            case SMART_EVENT_AGGRO:
            case SMART_EVENT_DEATH:
            case SMART_EVENT_EVADE:
            case SMART_EVENT_REACHED_HOME:
            case SMART_EVENT_CHARMED:
            case SMART_EVENT_CHARMED_TARGET:
            case SMART_EVENT_CORPSE_REMOVED:
            case SMART_EVENT_AI_INIT:
            case SMART_EVENT_TRANSPORT_ADDPLAYER:
            case SMART_EVENT_TRANSPORT_REMOVE_PLAYER:
            case SMART_EVENT_QUEST_ACCEPTED:
            case SMART_EVENT_QUEST_OBJ_COPLETETION:
            case SMART_EVENT_QUEST_COMPLETION:
            case SMART_EVENT_QUEST_REWARDED:
            case SMART_EVENT_QUEST_FAIL:
            case SMART_EVENT_JUST_SUMMONED:
            case SMART_EVENT_JUST_CREATED:
            case SMART_EVENT_GOSSIP_HELLO:
            case SMART_EVENT_FOLLOW_COMPLETED:
                return false;
            default:
                return true;
        }
    }
}

function writeToFile($file, $str)
{
    fwrite($file, $str . PHP_EOL);
}

function SAI2EAIFlag($flag)
{
    // Rather than making shitty stuff, lets do it plain.
    $output = 0;
    if (!($flag & EFLAG_REPEATABLE))
        $output |= SMART_EVENT_FLAG_NOT_REPEATABLE;
        
    if ($flag & EFLAG_DIFFICULTY_0)
        $output |= SMART_EVENT_FLAG_DIFFICULTY_0;
    
    if ($flag & EFLAG_DIFFICULTY_1)
        $output |= SMART_EVENT_FLAG_DIFFICULTY_1;

    if ($flag & EFLAG_DIFFICULTY_2)
        $output |= SMART_EVENT_FLAG_DIFFICULTY_2;

    if ($flag & EFLAG_DIFFICULTY_3)
        $output |= SMART_EVENT_FLAG_DIFFICULTY_3;

    if ($flag & EFLAG_DEBUG_ONLY)
        $output |= SMART_EVENT_FLAG_DEBUG_ONLY;
    
    return $output;
}

function writeCreatureText($data, $id, $size, $stream)
{
    $withHeader = ($id == 0);
    $data['comment'] = '"' . addslashes($data['comment']) . '"';

    $headerFields = implode('`, `', array_keys($data));
    $entry = implode(', ', array_values($data));
    
    $string = '(' . $entry . ')';
    if ($withHeader)
        $string = 'INSERT INTO `creature_text` (' . $headerFields . ') VALUES' . PHP_EOL . $string;
    
    if ($id == $size)
        $string .= ';';
    else
        $string .= ',';
    
    writeToFile($stream, $string);
}

function parseTexts($pdo, $outputFile, $npcId, $npcName, $param1)
{
    writeToFile($outputFile, '-- Texts for NPC ' . $npcName);
    writeToFile($outputFile, 'SET @ENTRY := ' . $npcId . ';');
    writeToFile($outputFile, 'DELETE FROM `creature_text` WHERE `entry`=' . $npcId . ';');

    $creatureAITexts = $pdo->query("SELECT * FROM creature_ai_texts WHERE entry = " . $param1);
    $textId = 0;
    $groupId = 0;
    $creatureTexts = array();
    
    while ($creatureText = $creatureAITexts->fetch(PDO::FETCH_OBJ)) {
        switch ($creatureText->type)
        {
            case 0:
            case 1:
            case 2:
                $creatureTexts[$textId] = new CreatureText($npcId, $textId, $groupId, $creatureText->sound, $npcName, $creatureText->emote, $creatureText->language, 100, 0, 12 + $creatureText->type * 2);
                break;
            case 3:
                $creatureTexts[$textId] = new CreatureText($npcId, $textId, $groupId, $creatureText->sound, $npcName, $creatureText->emote, $creatureText->language, 100, 0, 41);
                break;
            case 4:
                $creatureTexts[$textId] = new CreatureText($npcId, $textId, $groupId, $creatureText->sound, $npcName, $creatureText->emote, $creatureText->language, 100, 0, 15);
                break;
            case 5:
                $creatureTexts[$textId] = new CreatureText($npcId, $textId, $groupId, $creatureText->sound, $npcName, $creatureText->emote, $creatureText->language, 100, 0, 42);
                break;
            case 6:
                if ($creatureText->entry == -544)
                    $creatureTexts[$textId] = new CreatureText($npcId, $textId, $groupId, $creatureText->sound, $npcName, $creatureText->emote, $creatureText->language, 100, 0, 16);
                else if ($creatureText->entry == -860)
                    $creatureTexts[$textId] = new CreatureText($npcId, $textId, $groupId, $creatureText->sound, $npcName, $creatureText->emote, $creatureText->language, 100, 0, 12);
                break;
        }
        $creatureTexts[$textId]->setText($creatureText->content_default);
        $textId++;
    }
    
    # -- Debug code
    foreach ($creatureTexts as $itm)
        echo $itm. "<br />";
    
    return $creatureTexts;
}