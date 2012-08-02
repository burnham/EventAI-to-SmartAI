<?php
require_once('./sqlbuilder.class.php');
require_once('./eai.def.php');
require_once('./sai.def.php');

define('__FIXME__',  -1);

class Utils
{
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

    static function GetEventString($eventType, $params)
    {
        $param1 = $params[1];
        $param2 = $params[2];
        $param3 = $params[3];
        $param4 = $params[4];
        switch ($eventType)
        {
            case SMART_EVENT_UPDATE_IC:
                return "In Combat";
            case SMART_EVENT_UPDATE_OOC:
                return "Out Of Combat";
            case SMART_EVENT_HEALT_PCT:
                return "At ${param2}% HP";
            case SMART_EVENT_MANA_PCT:
                return "At ${param2}% Mana";
            case SMART_EVENT_AGGRO:
                return "On Aggro";
            case SMART_EVENT_KILL:
                return "On Killed Unit";
            case SMART_EVENT_DEATH:
                return "On Death";
            case SMART_EVENT_EVADE:
                return "On Evade";
            case SMART_EVENT_SPELLHIT:
                return "On Spellhit _spellHitSpellId_";
            case SMART_EVENT_RANGE:
                return "At ${param1} - ${param2} Range";
            case SMART_EVENT_OOC_LOS:
                return "On LOS Out Of Combat";
            case SMART_EVENT_RESPAWN:
                return "On Respawn";
            case SMART_EVENT_TARGET_HEALTH_PCT:
                return "On Target At ${param1} - ${param2}% HP";
            case SMART_EVENT_TARGET_CASTING:
                return "On Target Casting";
            case SMART_EVENT_FRIENDLY_HEALTH:
                return "On Friendly Unit At ${param1} - ${param2}% Health";
            case SMART_EVENT_FRIENDLY_IS_CC:
                return "On Friendly Unit In CC";
            case SMART_EVENT_FRIENDLY_MISSING_BUFF:
                return "On Friendly Buff Missing";
            case SMART_EVENT_SUMMONED_UNIT:
                return "On Summoned Unit";
            case SMART_EVENT_TARGET_MANA_PCT:
                return "On Target At ${param1} - ${param2}% Mana";
            case SMART_EVENT_ACCEPTED_QUEST:
                return "On Quest Accept";
            case SMART_EVENT_REWARD_QUEST:
                return "On Quest Reward";
            case SMART_EVENT_REACHED_HOME:
                return "Just Reached Home";
            case SMART_EVENT_RECEIVE_EMOTE:
                return "Received Emote";
            case SMART_EVENT_HAS_AURA:
                if ($param1 < 0)
                    return "On Aura _hasAuraSpellId_ Not Present";
                return "On Aura _hasAuraSpellId_ Present";
            case SMART_EVENT_TARGET_BUFFED:
                return "On Target Buffed";
            case SMART_EVENT_RESET:
                return "On Reset";
            case SMART_EVENT_IC_LOS:
                return "On LOS In Combat";
            case SMART_EVENT_PASSENGER_BOARDED:
                return "On Passenger Boarded";
            case SMART_EVENT_PASSENGER_REMOVED:
                return "On Passenger Removed";
            case SMART_EVENT_CHARMED:
                return "On Charmed";
            case SMART_EVENT_CHARMED_TARGET:
                return "On Charmed Target";
            case SMART_EVENT_SPELLHIT_TARGET:
                return "On Spell Hit Target";
            case SMART_EVENT_DAMAGED:
            case SMART_EVENT_DAMAGED_TARGET:
                return "Fixme -- SMART_EVENT_DAMAGED(_TARGET)"; # ???
            case SMART_EVENT_MOVEMENTINFORM:
                return "On Movement Inform";
            case SMART_EVENT_SUMMON_DESPAWNED:
                return "On Summoned Unit Despawn";
            case SMART_EVENT_CORPSE_REMOVED:
                return "On Corpse Removal";
            default:
                return "Fixme -- Add case";
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
    
    static function buildSAIAction($eaiItem) {
        $result = array();

        for ($i = 1; $i <= 3; $i++) {
            $eaiAction = $eaiItem->{'action'  . $i . '_type'};

            if ($eaiAction == 0)
                break;
            
            $param1    = $eaiItem->{'action'  . $i . '_param1'};
            $param2    = $eaiItem->{'action'  . $i . '_param2'};
            $param3    = $eaiItem->{'action'  . $i . '_param3'};

            switch ($eaiAction)
            {
                case ACTION_T_TEXT:
                    $result[$i] = array(
                        'extraData'   => Factory::createOrGetDBHandler()->query("SELECT * FROM `creature_ai_texts` WHERE `entry` IN (" . $param1 . "," . $param2 . "," . $param3 . ")")->fetchAll(PDO::FETCH_OBJ),
                        'SAIAction'   => SMART_ACTION_TALK,
                        'params'      => array($param1, $param2, $param3, 0, 0, 0),
                        'commentType' => "_npcName_ - _eventName_ - Say Line _lineEntry_"
                    );
                    break;
                case ACTION_T_SET_FACTION:
                    $result[$i] = array(
                        'SAIAction'   => SMART_ACTION_SET_FACTION,
                        'params'      => array($param1, $param2, $param3, 0, 0, 0),
                        'commentType' => "_npcName_ - _eventName_ - Set Faction " . $param1
                    );
                    break;
                case ACTION_T_MORPH_TO_ENTRY_OR_MODEL:
                    $result[$i] = array(
                        'SAIAction'   => SMART_ACTION_MORPH_TO_ENTRY_OR_MODEL,
                        'params'      => array($param1, $param2, $param3, 0, 0, 0),
                        'commentType' => "_npcName_ - _eventName_ - Morph Into " . $param1
                    );
                    break;
                case ACTION_T_SOUND:
                    $result[$i] = array(
                        'SAIAction'   => SMART_ACTION_SOUND,
                        'params'      => array($param1, max(0, min($param2, 1)), 0, 0, 0, 0), // param2 = 0: self, else all in vis range
                        'commentType' => "_npcName_ - _eventName_ - Play Sound " . $param1
                    );
                    break;
                case ACTION_T_EMOTE:
                    $result[$i] = array(
                        'SAIAction'  => SMART_ACTION_PLAY_EMOTE,
                        'params'     => array($param1, 0, 0, 0, 0, 0),
                        'commentType' => "_npcName_ - _eventName_ - Play Emote " . $param1
                    );
                    break;
                case ACTION_T_RANDOM_EMOTE:
                    $result[$i] = array(
                        'SAIAction'  => SMART_ACTION_RANDOM_EMOTE,
                        'params'     => array($param1, $param2, $param3, 0, 0, 0),
                        'commentType' => "_npcName_ - _eventName_ - Random Emote"
                    );
                    break;
                case ACTION_T_CAST:
                    $result[$i] = array(
                        'SAIAction'  => SMART_ACTION_CAST,
                        'params'     => array($param1, $param3, 0, 0, 0, 0),
                        'target'     => $param2 + 1,
                        'commentType' => "_npcName_ - _eventName_ - Cast _castSpellId_"
                    );
                    break;
                case ACTION_T_THREAT_SINGLE_PCT:
                    $target = $param2 + 1;
                case ACTION_T_THREAT_ALL_PCT:
                    //! Wiki is wrong here, we can have two arguments. First is added threat, second is removed threat.
                    //! Threat addition has priority over threat reduction!
                    $result[$i] = array(
                        'SAIAction'  => ($eaiAction == ACTION_T_THREAT_SINGLE_PCT ? SMART_ACTION_THREAT_SINGLE_PCT : SMART_ACTION_THREAT_ALL_PCT),
                        'params'     => array(max(0, $param1), max(0, -$param1), 0, 0, 0, 0),
                        'commentType' => "_npcName_ - _eventName_ - "
                    );
                    
                    if (isset($target))
                        $result[$i]['target'] = $target;
                    
                    if ($param1 < 0)
                        $result[$i]['commentType'] .= "Remove " . (- $param1) . '% Threat';
                    else // if ($param1 > 0)
                        $result[$i]['commentType'] .= "Add " . (- $param1) . '% Threat';
                    break;
                case ACTION_T_QUEST_EVENT_ALL:
                case ACTION_T_QUEST_EVENT:
                    $result[$i] = array(
                        'SAIAction'  => SMART_ACTION_CALL_AREAEXPLOREDOREVENTHAPPENS,
                        'params'     => array($param1, 0, 0, 0, 0, 0),
                        'commentType' => "_npcName_ - _eventName_ - Quest Credit"
                    );
                    if ($eaiAction == ACTION_T_QUEST_EVENT)
                        $result[$i]['target' ] = $param2 + 1;
                    break;
                case ACTION_T_CAST_EVENT_ALL:
                case ACTION_T_CAST_EVENT:
                    $result[$i] = array(
                        'SAIAction'  => SMART_ACTION_SEND_CASTCREATUREORGO,
                        'params'     => array($param1, $param2, 0, 0, 0, 0),
                        'commentType' => "_npcName_ - _eventName_ - Quest Credit"
                    );
                    if ($eaiAction == ACTION_T_CAST_EVENT)
                        $result[$i]['target' ] = $param3 + 1;
                    break;
                case ACTION_T_SET_UNIT_FIELD:
                    //! Not a  100% sure on this, requires deeper research. (Horn's comments based)
                    //! Not sure if it's param1 or param2!
                    $result[$i] = array(
                        'SAIAction'  => SMART_ACTION_SET_UNIT_FIELD_BYTES_1,
                        'params'     => array($param2, 0, 0, 0, 0, 0),
                        'target'     => $param3 + 1,
                        'commentType' => "_npcName_ - _eventName_ - Set Bytes1 " . $param2
                    );
                    break;
                case ACTION_T_SET_UNIT_FLAG:
                    $result[$i] = array(
                        'SAIAction'  => SMART_ACTION_SET_UNIT_FLAG,
                        'params'     => array($param1, 0, 0, 0, 0, 0),
                        'target'     => $param2 + 1,
                        'commentType' => "_npcName_ - _eventName_ - Set unit_flag " . $param1
                    );
                    break;
                case ACTION_T_REMOVE_UNIT_FLAG:
                    $result[$i] = array(
                        'SAIAction'  => SMART_ACTION_REMOVE_UNIT_FLAG,
                        'params'     => array($param1, 0, 0, 0, 0, 0),
                        'target'     => $param2 + 1,
                        'commentType' => "_npcName_ - _eventName_ - Remove unit_flag " . $param1
                    );
                    break;
                case ACTION_T_AUTO_ATTACK:
                    $result[$i] = array(
                        'SAIAction'  => SMART_ACTION_AUTO_ATTACK,
                        'params'     => array($param1, 0, 0, 0, 0, 0),
                        'commentType' => "_npcName_ - _eventName_ - Start Auto Attack"
                    );
                    break;
                case ACTION_T_COMBAT_MOVEMENT:
                    $result[$i] = array(
                        'SAIAction'  => SMART_ACTION_ALLOW_COMBAT_MOVEMENT,
                        'params'     => array($param1, 0, 0, 0, 0, 0),
                        'commentType' => "_npcName_ - _eventName_ - Allow Combat Movement"
                    );
                    break;
                case ACTION_T_SET_PHASE:
                    $result[$i] = array(
                        'SAIAction'  => SMART_ACTION_SET_EVENT_PHASE,
                        'params'     => array($param1, 0, 0, 0, 0, 0),
                        'commentType' => "_npcName_ - _eventName_ - Set Phase " . $param1
                    );
                    break;
                case ACTION_T_INC_PHASE:
                    $result[$i] = array(
                        'SAIAction'  => SMART_ACTION_INC_EVENT_PHASE,
                        'params'     => array(0, 0, 0, 0, 0, 0),
                        'commentType' => "_npcName_ - _eventName_ - Increment Phase"
                    );
                    
                    if ($param1 < 0)
                        $result[$i]['params'][1] = -$param1;
                    else // if ($param1 > 0)
                        $result[$i]['params'][0] = $param1;
                    break;
                case ACTION_T_EVADE:
                    $result[$i] = array(
                        'SAIAction'  => SMART_ACTION_EVADE,
                        'params'     => array(0, 0, 0, 0, 0, 0),
                        'commentType' => "_npcName_ - _eventName_ - Evade"
                    );
                    break;
                case ACTION_T_FLEE_FOR_ASSIST:
                    //! EAI has no parameter. I set the first one as 0 as default for the NPC not to emote when fleeing.
                    //! EAI needs another action for this. WE DONT. This action will be used to pick if we need to emote
                    //! on fleeing.
                    $result[$i] = array(
                        'SAIAction'  => SMART_ACTION_FLEE_FOR_ASSIST,
                        'params'     => array(0, 0, 0, 0, 0, 0),
                        'target'     => SMART_TARGET_NONE,
                        'commentType' => "_npcName_ - _eventName_ - Flee For Assist"
                    );
                    break;
                case ACTION_T_REMOVEAURASFROMSPELL:
                    $result[$i] = array(
                        'SAIAction'  => SMART_ACTION_REMOVEAURASFROMSPELL,
                        'params'     => array($param2, 0, 0, 0, 0, 0),
                        'target'     => $param1 + 1,
                        'commentType' => "_npcName_ - _eventName_ - Remove Aura _removeAuraSpell_" 
                    );
                    if ($param2 == 0)
                        $result[$i]['commentType'] = "_npcName_ - _eventName_ - Remova all auras";
                    break;
                case ACTION_T_RANGED_MOVEMENT:
                    $result[$i] = array(
                        'SAIAction'  => SMART_ACTION_SET_RANGED_MOVEMENT,
                        'params'     => array($param1, $param2, 0, 0, 0, 0),
                        'target'     => SMART_TARGET_SELF,
                        'commentType' => "_npcName_ - _eventName_ - Set Ranged Movement"
                    );
                    break;
                case ACTION_T_RANDOM_PHASE:
                    $result[$i] = array(
                        'SAIAction'  => SMART_ACTION_RANDOM_PHASE,
                        'params'     => array($param1, $param2, $param3, 0, 0, 0),
                        'commentType' => "_npcName_ - _eventName_ - Set Random Phase"
                    );
                    break;
                case ACTION_T_RANDOM_PHASE_RANGE:
                    //! TODO: Check if EAI is inclusive or exclusive (like SAI)
                    $result[$i] = array(
                        'SAIAction'  => SMART_ACTION_RANDOM_PHASE_RANGE,
                        'params'     => array($param1, $param2, 0, 0, 0, 0),
                        'commentType' => "_npcName_ - _eventName_ - Random Phase Range (${param1} - ${param2})" // Because i'm tired of concatenating
                    );
                    break;
                case ACTION_T_SUMMON:
                    //! Forcing SummonType to 1 as EAI doesnt handle it
                    $result[$i] = array(
                        'SAIAction'     => SMART_ACTION_SUMMON_CREATURE,
                        'params'        => array($param1, 1, $param3, 0, 0, 0),
                        'target'        => $param2 + 1,
                        'commentType'   => "_npcName_ - _eventName_ - Summon Creature " . Factory::createOrGetDBHandler()->query("SELECT `name` FROM `creature_template` WHERE `entry`=${param1}")->fetch(PDO::FETCH_OBJ)->name
                    );
                    break;
                case ACTION_T_SUMMON_ID:
                    $result[$i] = array(
                        'extraData'     => Factory::createOrGetDBHandler()->query("SELECT * FROM `creature_ai_summons` WHERE `id`=" . $param3)->fetch(PDO::FETCH_OBJ),
                        'SAIAction'     => SMART_ACTION_SUMMON_CREATURE,
                        'params'        => array($param1, 0, 0, 0, 0, 0),
                        'commentType'   => "_npcName_ - _eventName_ - Summon Creature " . Factory::createOrGetDBHandler()->query("SELECT `name` FROM `creature_template` WHERE `entry`=${param1}")->fetch(PDO::FETCH_OBJ)->name,
                        'isSpecialHandler' => true,
                    );
                    break;
                case ACTION_T_KILLED_MONSTER:
                    $result[$i] = array(
                        'SAIAction'  => SMART_ACTION_CALL_KILLEDMONSTER,
                        'params'     => array($param1, 0, 0, 0, 0, 0),
                        'target'     => $param2 + 1,
                        'commentType' => "_npcName_ - _eventName_ - Quest Credit"
                    );
                    break;
                case ACTION_T_SET_INST_DATA:
                    $result[$i] = array(
                        'SAIAction'  => SMART_ACTION_SET_INST_DATA,
                        'params'     => array($param1, $param2, 0, 0, 0, 0),
                        'commentType' => "_npcName_ - _eventName_ - Set Instance Data ${param1} to ${param2}"
                    );
                    break;
                case ACTION_T_SET_INST_DATA64:
                    $result[$i] = array(
                        'SAIAction'  => SMART_ACTION_SET_INST_DATA64,
                        'params'     => array($param1, 0, 0, 0, 0, 0),
                        'target'     => $param2 + 1,
                        'commentType' => "_npcName_ - _eventName_ - Set Instance Data64"
                    );
                    break;
                case ACTION_T_UPDATE_TEMPLATE:
                    $result[$i] = array(
                        'SAIAction'  => SMART_ACTION_UPDATE_TEMPLATE,
                        'params'     => array($param1, $param2, 0, 0, 0, 0),
                        'commentType' => "_npcName_ - _eventName_ - Update Template"
                    );
                    break;
                case ACTION_T_DIE:
                    $result[$i] = array(
                        'SAIAction'  => SMART_ACTION_DIE,
                        'params'     => array(0, 0, 0, 0, 0, 0),
                        'commentType' => "_npcName_ - _eventName_ - Die"
                    );
                    break;
                case ACTION_T_ZONE_COMBAT_PULSE:
                    $result[$i] = array(
                        'SAIAction'  => SMART_ACTION_SET_IN_COMBAT_WITH_ZONE,
                        'params'     => array(0, 0, 0, 0, 0, 0),
                        'commentType' => "_npcName_ - _eventName_ - Set In Combat With Zone"
                    );
                    break;
                case ACTION_T_CALL_FOR_HELP:
                    $result[$i] = array(
                        'SAIAction'  => SMART_ACTION_CALL_FOR_HELP,
                        'params'     => array($param1, 0, 0, 0, 0, 0),
                        'commentType' => "_npcName_ - _eventName_ - Call For Help"
                    );
                    break;
                case ACTION_T_SET_SHEATH:
                    $result[$i] = array(
                        'SAIAction'  => SMART_ACTION_SET_SHEATH,
                        'params'     => array($param1, 0, 0, 0, 0, 0),
                        'commentType' => "_npcName_ - _eventName_ - "
                    );

                    switch ($param1) 
                    {
                        case 0: // No melee weapon
                            $result[$i]['commentType'] .= 'Set unarmed';
                            break;
                        case 1: // Melee weapon
                            $result[$i]['commentType'] .= 'Display melee weapon';
                            break;
                        case 2: // Ranged
                            $result[$i]['commentType'] .= 'Display ranged weapon';
                            break;
                    }
                    break;
                case ACTION_T_FORCE_DESPAWN:
                    $result[$i] = array(
                        'SAIAction'  => SMART_ACTION_FORCE_DESPAWN,
                        'params'     => array($param1, 0, 0, 0, 0, 0),
                        'commentType' => "_npcName_ - _eventName_ - Forced Despawn"
                    );
                    break;
                case ACTION_T_SET_INVINCIBILITY_HP_LEVEL:
                    $result[$i] = array(
                        'SAIAction'  => SMART_ACTION_SET_INVINCIBILITY_HP_LEVEL,
                        'params'     => array($param1, 0, 0, 0, 0, 0),
                        'commentType' => "_npcName_ - _eventName_ - Set Invincibility Health Pct To " . $param1
                    );
                    break;
                case ACTION_T_MOUNT_TO_ENTRY_OR_MODEL:
                    $result[$i] = array(
                        'SAIAction'  => SMART_ACTION_MOUNT_TO_ENTRY_OR_MODEL,
                        'params'     => array($param1, $param2, 0, 0, 0, 0),
                        'commentType' => "_npcName_ - _eventName_ - Mount Up"
                    );

                    if ($param1 == 0 && $param2 == 0)
                        $result[$i]['commentType'] = "_npcName_ - _eventName_ - Dismount";
                    break;
                case ACTION_T_SET_PHASE_MASK:
                    $result[$i] = array(
                        'SAIAction'  => SMART_ACTION_SET_INGAME_PHASE_MASK,
                        'params'     => array($param1, 0, 0, 0, 0, 0),
                        'commentType' => "_npcName_ - _eventName_ - Set Phase"
                    );
                    break;
                case ACTION_T_SET_STAND_STATE:
                    $result[$i] = array(
                        'SAIAction'  => SMART_ACTION_SET_UNIT_FIELD_BYTES_1,
                        'params'     => array(0, 0, 0, 0, 0, 0),
                        'target'     => SMART_TARGET_SELF,
                        'commentType' => "_npcName_ - _eventName_ - Stand Up"
                    );
                    break;
                case ACTION_T_MOVE_RANDOM_POINT:
                    $result[$i] = array(
                        'SAIAction'  => SMART_ACTION_RANDOM_MOVE,
                        'params'     => array($param1, 0, 0, 0, 0, 0),
                        'commentType' => "_npcName_ - _eventName_ - Move Random"
                    );
                    break;
                case ACTION_T_SET_VISIBILITY:
                    $result[$i] = array(
                        'SAIAction'  => SMART_ACTION_SET_VISIBILITY,
                        'params'     => array($param1, 0, 0, 0, 0, 0),
                        'commentType' => "_npcName_ - _eventName_ - Set Visiblity"
                    );
                    break;
                case ACTION_T_SET_ACTIVE:
                    //! SAI has no parameter and cannot set a NPC as inactive!
                    $result[$i] = array(
                        'SAIAction'  => SMART_ACTION_SET_ACTIVE,
                        'params'     => array(0, 0, 0, 0, 0, 0),
                        'commentType' => "_npcName_ - _eventName_ - Set Active"
                    );
                    break;
                case ACTION_T_SET_AGGRESSIVE:
                    $result[$i] = array(
                        'SAIAction'  => SMART_ACTION_SET_REACT_STATE,
                        'params'     => array($param1, 0, 0, 0, 0, 0),
                        'commentType' => "_npcName_ - _eventName_ - Set React Aggressive"
                    );
                    break;
                case ACTION_T_ATTACK_START_PULSE:
                    $result[$i] = array(
                        'SAIAction'  => SMART_ACTION_ATTACK_START,
                        'params'     => array(0, 0, 0, 0, 0, 0),
                        'commentType' => "_npcName_ - _eventName_ - Attack Start"
                    );
                    break;
                case ACTION_T_SUMMON_GO:
                    $result[$i] = array(
                        'SAIAction'  => SMART_ACTION_SUMMON_GO,
                        'params'     => array($param1, $param2, 0, 0, 0, 0),
                        'commentType' => "_npcName_ - _eventName_ - Summon Gameobject " . Factory::createOrGetDBHandler()->query("SELECT name FROM gameobject_template WHERE entry = ${param1}")->fetch(PDO::FETCH_OBJ)->name
                    );
                    break;
                case ACTION_T_NONE:
                    $result[$i] = array(
                        'SAIAction'  => SMART_ACTION_NONE,
                        'params'     => array(0, 0, 0, 0, 0, 0),
                        'commentType' => "_npcName_ - _eventName_ - UNUSED"
                    );
                    break;
                case ACTION_T_RANDOM_SOUND:
                    //! No event for this in SAI, needs to be handled though imo
                case ACTION_T_RANDOM_SAY:
                case ACTION_T_RANDOM_YELL:
                case ACTION_T_RANDOM_TEXTEMOTE:
                default:
                    $result[$i] = array(
                        'SAIAction'  => __FIXME__,
                        'params'     => array(__FIXME__, __FIXME__, __FIXME__, __FIXME__, __FIXME__, __FIXME__),
                        'commentType' => "_npcName_ - _eventName_ - Y me not working ??? :("
                    );
                    break;
            }

            if (!isset($result[$i]['isSpecialHandler']))
                $result[$i]['isSpecialHandler'] = false;

            if (!isset($result[$i]['target'])) // Default target
                $result[$i]['target'] = SMART_TARGET_SELF;
        }

        return $result;
    }

    static function generateSAIPhase($eaiPhase) {
        //! Not sure if this how it should behave. EAI uses phases to force events NOT TO happen in phases. It means they happen in ~$phase to me.
        //! Except for 0. (Seems kind of idiot for an event to never happen.) If 0, even always happen.
        //! Sample output: 0b100 inverted is 0b011 (4 => 3)
        if ($eaiPhase == 0)
            return 0;

        $saiPhase = decbin(~$eaiPhase);
        return bindec(substr($saiPhase, -strlen(decbin($eaiPhase))));
    }
    
    // Not used, here as remnant to understand how targets are converted.
    static function EAITargetToSAI($eaiTarget) {
        //! Targets are the same, except SAI has then offsetted by +1.
        return $eaiTarget + 1;
    }
}


class sLog
{
    private function __construct() { }

    static function outString($msg) {
        if ($handle = fopen('dbErrors.log', 'a')) {
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