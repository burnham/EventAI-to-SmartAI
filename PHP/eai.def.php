<?php
# EventAI
define('EFLAG_REPEATABLE',            0x01); // Event repeats
define('EFLAG_DIFFICULTY_0',          0x02); // Event only occurs in instance difficulty 0
define('EFLAG_DIFFICULTY_1',          0x04); // Event only occurs in instance difficulty 1
define('EFLAG_DIFFICULTY_2',          0x08); // Event only occurs in instance difficulty 2
define('EFLAG_DIFFICULTY_3',          0x10); // Event only occurs in instance difficulty 3
define('EFLAG_RESERVED_5',            0x20);
define('EFLAG_RESERVED_6',            0x40);
define('EFLAG_DEBUG_ONLY',            0x80); // Event only occurs in debug build
define('EFLAG_DIFFICULTY_ALL',        (EFLAG_DIFFICULTY_0|EFLAG_DIFFICULTY_1|EFLAG_DIFFICULTY_2|EFLAG_DIFFICULTY_3));

define('EVENT_T_TIMER',                   0);  // InitialMin, InitialMax, RepeatMin, RepeatMax
define('EVENT_T_TIMER_OOC',               1);  // InitialMin, InitialMax, RepeatMin, RepeatMax
define('EVENT_T_HP',                      2);  // HPMax%, HPMin%, RepeatMin, RepeatMax
define('EVENT_T_MANA',                    3);  // ManaMax%, ManaMin% RepeatMin, RepeatMax
define('EVENT_T_AGGRO',                   4);  // NONE
define('EVENT_T_KILL',                    5);  // RepeatMin, RepeatMax
define('EVENT_T_DEATH',                   6);  // NONE
define('EVENT_T_EVADE',                   7);  // NONE
define('EVENT_T_SPELLHIT',                8);  // SpellID, School, RepeatMin, RepeatMax
define('EVENT_T_RANGE',                   9);  // MinDist, MaxDist, RepeatMin, RepeatMax
define('EVENT_T_OOC_LOS',                 10); // NoHostile, MaxRnage, RepeatMin, RepeatMax
define('EVENT_T_SPAWNED',                 11); // Condition, CondValue1
define('EVENT_T_TARGET_HP',               12); // HPMax%, HPMin%, RepeatMin, RepeatMax
define('EVENT_T_TARGET_CASTING',          13); // RepeatMin, RepeatMax
define('EVENT_T_FRIENDLY_HP',             14); // HPDeficit, Radius, RepeatMin, RepeatMax
define('EVENT_T_FRIENDLY_IS_CC',          15); // DispelType, Radius, RepeatMin, RepeatMax
define('EVENT_T_FRIENDLY_MISSING_BUFF',   16); // SpellId, Radius, RepeatMin, RepeatMax
define('EVENT_T_SUMMONED_UNIT',           17); // CreatureId, RepeatMin, RepeatMax
define('EVENT_T_TARGET_MANA',             18); // ManaMax%, ManaMin%, RepeatMin, RepeatMax
define('EVENT_T_QUEST_ACCEPT',            19); // QuestID
define('EVENT_T_QUEST_COMPLETE',          20); //
define('EVENT_T_REACHED_HOME',            21); // NONE
define('EVENT_T_RECEIVE_EMOTE',           22); // EmoteId, Condition, CondValue1, CondValue2
define('EVENT_T_BUFFED',                  23); // Param1 = SpellID, Param2 = Number of Time STacked, Param3/4 Repeat Min/Max
define('EVENT_T_TARGET_BUFFED',           24); // Param1 = SpellID, Param2 = Number of Time STacked, Param3/4 Repeat Min/Max
define('EVENT_T_RESET',                   35); // Is it called after combat, when the creature respawn and spawn. -- TRINITY ONLY

define('ACTION_T_NONE',                       0);  // No action
define('ACTION_T_TEXT',                       1);  // TextId1, optionally -TextId2, optionally -TextId3(if -TextId2 exist). If more than just -TextId1 is defined, randomize. Negative values.
define('ACTION_T_SET_FACTION',                2);  // FactionId (or 0 for default)
define('ACTION_T_MORPH_TO_ENTRY_OR_MODEL',    3);  // Creature_template entry(param1) OR ModelId (param2) (or 0 for both to demorph)
define('ACTION_T_SOUND',                      4);  // SoundId
define('ACTION_T_EMOTE',                      5);  // EmoteId
define('ACTION_T_RANDOM_SAY',                 6);  // UNUSED
define('ACTION_T_RANDOM_YELL',                7);  // UNUSED
define('ACTION_T_RANDOM_TEXTEMOTE',           8);  // UNUSED
define('ACTION_T_RANDOM_SOUND',               9);  // SoundId1, SoundId2, SoundId3 (-1 in any field means no output if randomed that field)
define('ACTION_T_RANDOM_EMOTE',               10); // EmoteId1, EmoteId2, EmoteId3 (-1 in any field means no output if randomed that field)
define('ACTION_T_CAST',                       11); // SpellId, Target, CastFlags
define('ACTION_T_SUMMON',                     12); // CreatureID, Target, Duration in ms
define('ACTION_T_THREAT_SINGLE_PCT',          13); // Threat%, Target
define('ACTION_T_THREAT_ALL_PCT',             14); // Threat%
define('ACTION_T_QUEST_EVENT',                15); // QuestID, Target
define('ACTION_T_CAST_EVENT',                 16); // QuestID, SpellId, Target - must be removed as hack?
define('ACTION_T_SET_UNIT_FIELD',             17); // Field_Number, Value, Target
define('ACTION_T_SET_UNIT_FLAG',              18); // Flags (may be more than one field OR'd together), Target
define('ACTION_T_REMOVE_UNIT_FLAG',           19); // Flags (may be more than one field OR'd together), Target
define('ACTION_T_AUTO_ATTACK',                20); // AllowAttackState (0 = stop attack, anything else means continue attacking)
define('ACTION_T_COMBAT_MOVEMENT',            21); // AllowCombatMovement (0 = stop combat based movement, anything else continue attacking)
define('ACTION_T_SET_PHASE',                  22); // Phase
define('ACTION_T_INC_PHASE',                  23); // Value (may be negative to decrement phase, should not be 0)
define('ACTION_T_EVADE',                      24); // No Params
define('ACTION_T_FLEE_FOR_ASSIST',            25); // No Params
define('ACTION_T_QUEST_EVENT_ALL',            26); // QuestID
define('ACTION_T_CAST_EVENT_ALL',             27); // CreatureId, SpellId
define('ACTION_T_REMOVEAURASFROMSPELL',       28); // Target, Spellid
define('ACTION_T_RANGED_MOVEMENT',            29); // Distance, Angle
define('ACTION_T_RANDOM_PHASE',               30); // PhaseId1, PhaseId2, PhaseId3
define('ACTION_T_RANDOM_PHASE_RANGE',         31); // PhaseMin, PhaseMax
define('ACTION_T_SUMMON_ID',                  32); // CreatureId, Target, SpawnId
define('ACTION_T_KILLED_MONSTER',             33); // CreatureId, Target
define('ACTION_T_SET_INST_DATA',              34); // Field, Data
define('ACTION_T_SET_INST_DATA64',            35); // Field, Target
define('ACTION_T_UPDATE_TEMPLATE',            36); // Entry, Team
define('ACTION_T_DIE',                        37); // No Params
define('ACTION_T_ZONE_COMBAT_PULSE',          38); // No Params
define('ACTION_T_CALL_FOR_HELP',              39); // Radius
define('ACTION_T_SET_SHEATH',                 40); // Sheath (0-passive, 1-melee, 2-ranged)
define('ACTION_T_FORCE_DESPAWN',              41); // Timer
define('ACTION_T_SET_INVINCIBILITY_HP_LEVEL', 42); // MinHpValue, format(0-flat, 1-percent from max health)
define('ACTION_T_MOUNT_TO_ENTRY_OR_MODEL',    43); // Creature_template entry(param1) OR ModelId (param2) (or 0 for both to dismount)
define('ACTION_T_SET_PHASE_MASK',             97); 
define('ACTION_T_SET_STAND_STATE',            98); 
define('ACTION_T_MOVE_RANDOM_POINT',          99); 
define('ACTION_T_SET_VISIBILITY',             100); 
define('ACTION_T_SET_ACTIVE',                 101);  //Apply
define('ACTION_T_SET_AGGRESSIVE',             102);  //Apply
define('ACTION_T_ATTACK_START_PULSE',         103);  //Distance
define('ACTION_T_SUMMON_GO',                  104);  //GameObjectID, DespawnTime in ms
define('ACTION_T_END',                        105); 

define("TARGET_T_SELF",                       0);
define("TARGET_T_HOSTILE",                    1);
define("TARGET_T_HOSTILE_SECOND_AGGRO",       2);
define("TARGET_T_HOSTILE_LAST_AGGRO",         3);
define("TARGET_T_HOSTILE_RANDOM",             4);
define("TARGET_T_HOSTILE_RANDOM_NOT_TOP",     5);
define("TARGET_T_ACTION_INVOKER",             6);
