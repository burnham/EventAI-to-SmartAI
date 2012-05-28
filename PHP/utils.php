<?php
require_once('./sqlbuilder.class.php');
require_once('./eai.def.php');
require_once('./sai.def.php');

class Utils
{
    static function hasParameters($eventId) {
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
    
    static function writeToFile($file, $str)
    {
        fwrite($file, $str . PHP_EOL);
    }
    
    static function SAI2EAIFlag($flag)
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

    static function convertEventToSAI($eventId) {
        switch ($eventId)
        {
            case EVENT_T_TIMER:
                return SMART_EVENT_UPDATE_IC;
            case EVENT_T_TIMER_OOC:
                return SMART_EVENT_UPDATE_OOC;
            case EVENT_T_HP:
                return SMART_EVENT_HEALT_PCT;
            case EVENT_T_MANA:
                return SMART_EVENT_MANA_PCT;
            case EVENT_T_AGGRO:
                return SMART_EVENT_AGGRO;
            case EVENT_T_KILL:
                return SMART_EVENT_KILL;
            case EVENT_T_DEATH:
                return SMART_EVENT_DEATH;
            case EVENT_T_EVADE:
                return SMART_EVENT_EVADE;
            case EVENT_T_SPELLHIT:
                return SMART_EVENT_SPELLHIT;
            case EVENT_T_RANGE:
                return SMART_EVENT_RANGE;
            case EVENT_T_OOC_LOS:
                return SMART_EVENT_OOC_LOS;
            case EVENT_T_SPAWNED:
                return SMART_EVENT_RESPAWN;
            case EVENT_T_TARGET_CASTING:
                return SMART_EVENT_TARGET_CASTING;
            case EVENT_T_TARGET_HP:
                return SMART_EVENT_TARGET_HEALTH_PCT;
            case EVENT_T_FRIENDLY_HP:
                return SMART_EVENT_FRIENDLY_HEALTH;
            case EVENT_T_FRIENDLY_IS_CC:
                return SMART_EVENT_FRIENDLY_IS_CC;
            case EVENT_T_FRIENDLY_MISSING_BUFF:
                return SMART_EVENT_FRIENDLY_MISSING_BUFF;
            case EVENT_T_SUMMONED_UNIT:
                return SMART_EVENT_SUMMONED_UNIT;
            case EVENT_T_TARGET_MANA:
                return SMART_EVENT_TARGET_MANA_PCT;
            case EVENT_T_QUEST_ACCEPT:
                return SMART_EVENT_ACCEPTED_QUEST;
            case EVENT_T_QUEST_COMPLETE:
                return SMART_EVENT_REWARD_QUEST;
            case EVENT_T_REACHED_HOME:
                return SMART_EVENT_REACHED_HOME;
            case EVENT_T_RECEIVE_EMOTE:
                return SMART_EVENT_RECEIVE_EMOTE;
            case EVENT_T_BUFFED:
                return SMART_EVENT_HAS_AURA;
            case EVENT_T_TARGET_BUFFED:
                return SMART_EVENT_TARGET_BUFFED;
            case EVENT_T_RESET:
                return SMART_EVENT_RESET;
            default:
                return SMART_EVENT_END;
        }
    }
    
    static function convertParamsToSAI($eaiItem) {
        $data = array();
        switch ($eaiItem->event_type)
        {
            case EVENT_T_HP:
            case EVENT_T_MANA:
            case EVENT_T_TARGET_HP:
                $data[1] = $eaiItem->event_param2;
                $data[2] = $eaiItem->event_param1;
                $data[3] = $eaiItem->event_param3;
                $data[4] = $eaiItem->event_param4;
                break;
            case EVENT_T_FRIENDLY_HP:
                $data[1] = 0;
                $data[2] = $eaiItem->event_param2;
                $data[3] = $eaiItem->event_param3;
                $data[4] = $eaiItem->event_param4;
                break;
            case EVENT_T_RECEIVE_EMOTE: // SAI'S SMART_EVENT_RECEIVE_EMOTE doesn't have the same structure at all. Fixme!
                $data[1] = $eaiItem->event_param1;
                $data[2] = $data[3] = 1000;
                $data[4] = 0;
                break;
            default:
                $data[1] = $eaiItem->event_param1;
                $data[2] = $eaiItem->event_param2;
                $data[3] = $eaiItem->event_param3;
                $data[4] = $eaiItem->event_param4;
                break;            
        }
        return array_map('intval', $data);
    }
    
    static function buildSAIAction($eaiAction, $param1, $param2, $param3, $pdo) {
        switch ($eaiAction)
        {
            case ACTION_T_TEXT:
            {
                $texts = $pdo->query("SELECT * FROM creature_ai_texts WHERE entry IN (${param1}, ${param2}, {$param3})")->fetch(PDO::FETCH_OBJ);
                
                return array(
                    'dumpedTexts' => $texts,
                    'SAIAction'   => SMART_ACTION_TALK,
                    'params'      => array($param1, $param2, $param3, 0, 0, 0)
                );
            }
            case ACTION_T_SET_FACTION:
                return array(
                    'SAIAction'  => SMART_ACTION_SET_FACTION,
                    'params'     => array($param1, $param2, $param3, 0, 0, 0)
                );
            case ACTION_T_MORPH_TO_ENTRY_OR_MODEL:
                return array(
                    'SAIAction'  => SMART_ACTION_MORPH_TO_ENTRY_OR_MODEL
                    'params'     => array($param1, $param2, $param3, 0, 0, 0)
                );
            case ACTION_T_SOUND:
                return array(
                    'SAIAction'  => SMART_ACTION_SOUND,
                    'params'     => array($param1, $param2, 0, 0, 0, 0) // param2 = 0: self, else all in vis range
                );
            case ACTION_T_EMOTE:
                return array(
                    'SAIAction'  => SMART_ACTION_PLAY_EMOTE,
                    'params'     => array($param1, 0, 0, 0, 0, 0)
                );
            case ACTION_T_RANDOM_EMOTE:
                return array(
                    'SAIAction'  => SMART_ACTION_RANDOM_EMOTE,
                    'params'     => array($param1, $param2, $param3, 0, 0, 0)
                );
            case ACTION_T_CAST:
                return array(
                    'SAIAction'  => SMART_ACTION_CAST,
                    'params'     => array($param1, $param3, 0, 0, 0, 0)
                );
            case ACTION_T_SUMMON:
                return array(
                    'SAIAction'  => SMART_ACTION_SUMMON_CREATURE,
                    'params'     => array($param1, __FIXME__, $param3, 0, __FIXME__, 0);
                );
            case ACTION_T_THREAT_SINGLE_PCT:
                return array(
                    'SAIAction'  => SMART_ACTION_THREAT_SINGLE_PCT,
                    'params'     => array($param1, 0, 0, 0, 0, 0)
                );
            case ACTION_T_RANDOM_SOUND: // No event for this in SAI, needs to be handled though
                return array();
            case ACTION_T_RANDOM_SAY: // Unused
            case ACTION_T_RANDOM_YELL:
            case ACTION_T_RANDOM_TEXTEMOTE:
            default:
                return array();
        }
    }
}