<?php
require_once('./sqlbuilder.class.php');
require_once('./eai.def.php');
require_once('./sai.def.php');

define('__FIXME__',  -1);

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
    
    static function buildSAIAction($eaiItem, $pdo) {
        $result = array();
        for ($i = 1; $i < 4; $i++) {
            $eaiAction = $eaiItem->{'action'  . $i . '_type'};
            $param1    = $eaiItem->{'action'  . $i . '_param1'};
            $param2    = $eaiItem->{'action'  . $i . '_param2'};
            $param3    = $eaiItem->{'action'  . $i . '_param3'};
            switch ($eaiAction)
            {
                case ACTION_T_TEXT:
                    $result[$i] = array(
                        'dumpedTexts' => $pdo->query("SELECT * FROM creature_ai_texts WHERE entry IN (" . $param1 . "," . $param2 . "," . $param3 . ")")->fetchAll(PDO::FETCH_OBJ),
                        'SAIAction'   => SMART_ACTION_TALK,
                        'params'      => array($param1, $param2, $param3, 0, 0, 0)
                    );
                    break;
                case ACTION_T_SET_FACTION:
                    $result[$i] = array(
                        'SAIAction'  => SMART_ACTION_SET_FACTION,
                        'params'     => array($param1, $param2, $param3, 0, 0, 0)
                    );
                    break;
                case ACTION_T_MORPH_TO_ENTRY_OR_MODEL:
                    $result[$i] = array(
                        'SAIAction'  => SMART_ACTION_MORPH_TO_ENTRY_OR_MODEL,
                        'params'     => array($param1, $param2, $param3, 0, 0, 0)
                    );
                    break;
                case ACTION_T_SOUND:
                    $result[$i] = array(
                        'SAIAction'  => SMART_ACTION_SOUND,
                        'params'     => array($param1, max(0, min($param2, 1)), 0, 0, 0, 0) // param2 = 0: self, else all in vis range
                    );
                    break;
                case ACTION_T_EMOTE:
                    $result[$i] = array(
                        'SAIAction'  => SMART_ACTION_PLAY_EMOTE,
                        'params'     => array($param1, 0, 0, 0, 0, 0)
                    );
                    break;
                case ACTION_T_RANDOM_EMOTE:
                    $result[$i] = array(
                        'SAIAction'  => SMART_ACTION_RANDOM_EMOTE,
                        'params'     => array($param1, $param2, $param3, 0, 0, 0)
                    );
                    break;
                case ACTION_T_CAST:
                    $result[$i] = array(
                        'SAIAction'  => SMART_ACTION_CAST,
                        'params'     => array($param1, $param3, 0, 0, 0, 0),
                        'target'     => Utils::EAITargetToSAI($param2)
                    );
                    break;
                case ACTION_T_THREAT_SINGLE_PCT:
                case ACTION_T_THREAT_ALL_PCT:
                    //! Wiki is wrong here, we can have two arguments. First is added threat, second is removed threat.
                    //! Threat addition has priority over threat reduction!
                    $result[$i] = array(
                        'SAIAction'  => ($eaiAction == ACTION_T_THREAT_SINGLE_PCT ? SMART_ACTION_THREAT_SINGLE_PCT : SMART_ACTION_THREAT_ALL_PCT),
                        'params'     => array(max(0, $param1), min(0, $param1), 0, 0, 0, 0)
                    );
                    break;
                case ACTION_T_QUEST_EVENT_ALL:
                case ACTION_T_QUEST_EVENT:
                    $result[$i] = array(
                        'SAIAction'  => SMART_ACTION_CALL_AREAEXPLOREDOREVENTHAPPENS,
                        'params'     => array($param1, 0, 0, 0, 0, 0)
                    );
                    break;
                case ACTION_T_CAST_EVENT_ALL:
                case ACTION_T_CAST_EVENT:
                    $result[$i] = array(
                        'SAIAction'  => SMART_ACTION_SEND_CASTCREATUREORGO,
                        'params'     => array($param1, $param2, 0, 0, 0, 0)
                    );
                    break;
                case ACTION_T_SET_UNIT_FIELD:
                    //! Not a  100% sure on this, requires deeper research. (Horn's comments based)
                    //! Not sure if it's param1 or param2!
                    $result[$i] = array(
                        'SAIAction'  => SMART_ACTION_SET_UNIT_FIELD_BYTES_1,
                        'params'     => array($param2, 0, 0, 0, 0, 0)
                    );
                    break;
                case ACTION_T_SET_UNIT_FLAG:
                case ACTION_T_REMOVE_UNIT_FLAG:
                    $result[$i] = array(
                        'SAIAction'  => ($eaiAction == ACTION_T_SET_UNIT_FLAG ? SMART_ACTION_SET_UNIT_FLAG : SMART_ACTION_REMOVE_UNIT_FLAG),
                        'params'     => array($param1, 0, 0, 0, 0, 0)
                    );
                    break;
                case ACTION_T_AUTO_ATTACK:
                    $result[$i] = array(
                        'SAIAction'  => SMART_ACTION_AUTO_ATTACK,
                        'params'     => array($param1, 0, 0, 0, 0, 0)
                    );
                    break;
                case ACTION_T_COMBAT_MOVEMENT:
                    $result[$i] = array(
                        'SAIAction'  => SMART_ACTION_ALLOW_COMBAT_MOVEMENT,
                        'params'     => array($param1, 0, 0, 0, 0, 0)
                    );
                    break;
                case ACTION_T_SET_PHASE:
                    $result[$i] = array(
                        'SAIAction'  => SMART_ACTION_SET_EVENT_PHASE,
                        'params'     => array($param1, 0, 0, 0, 0, 0)
                    );
                    break;
                case ACTION_T_INC_PHASE:
                    //! EAI uses only one parameter. SAI uses two: first, we decrease, then we increase. I don't get the difference.
                    return sLog::outString('Tried to cast ACTION_T_INC_PHASE to SMART_ACTION_INC_EVENT_PHASE, but parameters are not totally handled! Aborting');
                    $result[$i] = array(
                        'SAIAction'  => SMART_ACTION_INC_EVENT_PHASE,
                        'params'     => array(__FIXME__, __FIXME__, __FIXME__, __FIXME__, __FIXME__, __FIXME__)
                    );
                    break;
                case ACTION_T_EVADE:
                    $result[$i] = array(
                        'SAIAction'  => SMART_ACTION_EVADE,
                        'params'     => array(0, 0, 0, 0, 0, 0)
                    );
                    break;
                case ACTION_T_FLEE_FOR_ASSIST:
                    //! EAI has no parameter. I set the first one as 0 as default for the NPC not to emote when fleeing.
                    //! EAI needs another action for this. WE DONT. This action will be used to pick if we need to emote
                    //! on fleeing.
                    $result[$i] = array(
                        'SAIAction'  => SMART_ACTION_FLEE_FOR_ASSIST,
                        'params'     => array(0, 0, 0, 0, 0, 0)
                    );
                    break;
                case ACTION_T_REMOVEAURASFROMSPELL:
                    $result[$i] = array(
                        'SAIAction'  => SMART_ACTION_REMOVEAURASFROMSPELL,
                        'params'     => array($param2, 0, 0, 0, 0, 0)
                    );
                    break;
                case ACTION_T_RANGED_MOVEMENT:
                    return sLog::outString('Tried to cast ACTION_T_RANGED_MOVEMENT to SAI, but this event does not exist in SAI! Aborting.');
                    $result[$i] = array(
                        'SAIAction'  => __FIXME__,
                        'params'     => array(__FIXME__, __FIXME__, __FIXME__, __FIXME__, __FIXME__, __FIXME__)
                    );
                    break;
                case ACTION_T_RANDOM_PHASE:
                    $result[$i] = array(
                        'SAIAction'  => SMART_ACTION_RANDOM_PHASE,
                        'params'     => array($param1, $param2, $param3, 0, 0, 0)
                    );
                    break;
                case ACTION_T_RANDOM_PHASE_RANGE:
                    //! TODO: Check if EAI is inclusive or exclusive (like SAI)
                    $result[$i] = array(
                        'SAIAction'  => SMART_ACTION_RANDOM_PHASE_RANGE,
                        'params'     => array($param1, $param2)
                    );
                    break;
                case ACTION_T_SUMMON:
                    //! Forcing SummonType to 1 as EAI doesnt handle it
                    $result[$i] = array(
                        'spawnTimeSecs' => $pdo->query('SELECT spawntimesecs FROM creature_ai_summons WHERE id = ' . $param3)->fetch(PDO::FETCH_OBJ),
                        'SAIAction'     => SMART_ACTION_SUMMON_CREATURE,
                        'params'        => array($param1, 1, 'selfArray::spawnTimeSecs', 0, 0, 0)
                    );
                    break;
                case ACTION_T_KILLED_MONSTER:
                    $result[$i] = array(
                        'SAIAction'  => SMART_ACTION_CALL_KILLEDMONSTER,
                        'params'     => array($param1, 0, 0, 0, 0, 0)
                    );
                    break;
                case ACTION_T_SET_INST_DATA:
                    $result[$i] = array(
                        'SAIAction'  => SMART_ACTION_SET_INST_DATA,
                        'params'     => array($param1, $param2)
                    );
                    break;
                case ACTION_T_SET_INST_DATA64:
                    $result[$i] = array(
                        'SAIAction'  => SMART_ACTION_SET_INST_DATA64,
                        'params'     => array($param1, 0, 0, 0, 0, 0)
                    );
                    break;
                case ACTION_T_UPDATE_TEMPLATE:
                    $result[$i] = array(
                        'SAIAction'  => SMART_ACTION_UPDATE_TEMPLATE,
                        'params'     => array($param1, $param2, 0, 0, 0, 0)
                    );
                    break;
                case ACTION_T_DIE:
                    $result[$i] = array(
                        'SAIAction'  => SMART_ACTION_DIE,
                        'params'     => array(0, 0, 0, 0, 0, 0)
                    );
                    break;
                case ACTION_T_ZONE_COMBAT_PULSE:
                    $result[$i] = array(
                        'SAIAction'  => SMART_ACTION_SET_IN_COMBAT_WITH_ZONE,
                        'params'     => array(0, 0, 0, 0, 0, 0)
                    );
                    break;
                case ACTION_T_CALL_FOR_HELP:
                    $result[$i] = array(
                        'SAIAction'  => SMART_ACTION_CALL_FOR_HELP,
                        'params'     => array($param1, 0, 0, 0, 0, 0)
                    );
                    break;
                case ACTION_T_SET_SHEATH:
                    $result[$i] = array(
                        'SAIAction'  => SMART_ACTION_SET_SHEATH,
                        'params'     => array($param1, 0, 0, 0, 0, 0)
                    );
                    break;
                case ACTION_T_FORCE_DESPAWN:
                    $result[$i] = array(
                        'SAIAction'  => SMART_ACTION_FORCE_DESPAWN,
                        'params'     => array($param1, 0, 0, 0, 0, 0)
                    );
                    break;
                case ACTION_T_SET_INVINCIBILITY_HP_LEVEL:
                    $result[$i] = array(
                        'SAIAction'  => SMART_ACTION_SET_INVINCIBILITY_HP_LEVEL,
                        'params'     => array($param1, 0, 0, 0, 0, 0)
                    );
                    break;
                case ACTION_T_MOUNT_TO_ENTRY_OR_MODEL:
                    $result[$i] = array(
                        'SAIAction'  => SMART_ACTION_MOUNT_TO_ENTRY_OR_MODEL,
                        'params'     => array($param1, $param2, 0, 0, 0, 0)
                    );
                    break;
                case ACTION_T_SET_PHASE_MASK:
                    $result[$i] = array(
                        'SAIAction'  => SMART_ACTION_SET_INGAME_PHASE_MASK,
                        'params'     => array($param1, 0, 0, 0, 0, 0)
                    );
                    break;
                case ACTION_T_SET_STAND_STATE:
                    //! Not found in SAI
                    return sLog::outString('Tried to cast ACTION_T_SET_STAND_STATE to SAI, but this event does not seem to exist in SAI! Aborting.');
                    $result[$i] = array(
                        'SAIAction'  => __FIXME__,
                        'params'     => array(__FIXME__, __FIXME__, __FIXME__, __FIXME__, __FIXME__, __FIXME__)
                    );
                    break;
                case ACTION_T_MOVE_RANDOM_POINT:
                    $result[$i] = array(
                        'SAIAction'  => SMART_ACTION_RANDOM_MOVE,
                        'params'     => array($param1, 0, 0, 0, 0, 0)
                    );
                    break;
                case ACTION_T_SET_VISIBILITY:
                    $result[$i] = array(
                        'SAIAction'  => SMART_ACTION_SET_VISIBILITY,
                        'params'     => array($param1, 0, 0, 0, 0, 0)
                    );
                    break;
                case ACTION_T_SET_ACTIVE:
                    //! SAI has no parameter and cannot set a NPC as inactive!
                    $result[$i] = array(
                        'SAIAction'  => SMART_ACTION_SET_ACTIVE,
                        'params'     => array(0, 0, 0, 0, 0, 0)
                    );
                    break;
                case ACTION_T_SET_AGGRESSIVE:
                    $result[$i] = array(
                        'SAIAction'  => SMART_ACTION_SET_REACT_STATE,
                        'params'     => array($param1, 0, 0, 0, 0, 0)
                    );
                    break;
                case ACTION_T_ATTACK_START_PULSE:
                    $result[$i] = array(
                        'SAIAction'  => SMART_ACTION_ATTACK_START,
                        'params'     => array(0, 0, 0, 0, 0, 0)
                    );
                    break;
                case ACTION_T_SUMMON_GO:
                    $result[$i] = array(
                        'SAIAction'  => SMART_ACTION_SUMMON_GO,
                        'params'     => array($param1, $param2, 0, 0, 0, 0)
                    );
                    break;
                case ACTION_T_RANDOM_SOUND:
                    //! No event for this in SAI, needs to be handled though imo
                    $result[$i] = array();
                    break;
                // These are unused
                case ACTION_T_RANDOM_SAY:
                case ACTION_T_RANDOM_YELL:
                case ACTION_T_RANDOM_TEXTEMOTE:
                default:
                    $result[$i] = array();
            }
        }
        
        return $result;
    }
    
    static function generateSAIPhase($eaiPhase) {
        //! Not sure if this how it should behave. EAI uses phases to force events NOT TO happen in phases. It means they happen in ~$phase to me.
        //! Except for 0. (Seems kind of idiot for an event to never happen.)
        //! Sample output: 0b100 inverted is 0b011 (4 => 3)
        if ($eaiPhase == 0)
            return 0;

        $saiPhase = decbin(~$eaiPhase);
        return bindec(substr($saiPhase, -strlen(decbin($eaiPhase))));
    }
    
    static function EAITargetToSAI($eaiTarget) {
        //! Targets are the same, except SAI has then offsetted by +1.
        return $eaiTarget + 1;
    }
}


class sLog
{
    private function __construct() { }

    static function outString($msg) {
        if ($handle = fopen('dbErrors.log', 'w+')) {
            fwrite($handle, date('d/m/Y H:i:s :: ') . $msg . PHP_EOL);
            fclose($handle);
        }
    }

    static function outInfo($msg) {
        if ($handle = fopen('workProgress.log', 'a')) {
            fwrite($handle, date('d/m/Y H:i:s :: ') . $msg . PHP_EOL);
            fclose($handle);
        }
    }

    static function outSpecificFile($file, $msg) {
        if ($handle = fopen($file, 'a')) {
            fwrite($handle, $msg);
            fclose($handle);
        }
    }
}