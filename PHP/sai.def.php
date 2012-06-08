<?php
# Defines various data for the converter script
define('SMART_SCRIPT_TYPE_CREATURE',          0);
define('SMART_SCRIPT_TYPE_GAMEOBJECT',        1);
define('SMART_SCRIPT_TYPE_AREATRIGGER',       2);
define('SMART_SCRIPT_TYPE_EVENT',             3); // Not yet implemented. We'll converted them, anyways
define('SMART_SCRIPT_TYPE_GOSSIP',            4); // Not yet implemented. We'll converted them, anyways
define('SMART_SCRIPT_TYPE_QUEST',             5); // Not yet implemented. We'll converted them, anyways
define('SMART_SCRIPT_TYPE_SPELL',             6); // Not yet implemented. We'll converted them, anyways
define('SMART_SCRIPT_TYPE_TRANSPORT',         7); // Not yet implemented. We'll converted them, anyways
define('SMART_SCRIPT_TYPE_INSTANCE',          8); // Not yet implemented. We'll converted them, anyways
define('SMART_SCRIPT_TYPE_TIMED_ACTIONLIST',  9);

define('SMART_EVENT_UPDATE_IC',               0);    // InitialMin, InitialMax, RepeatMin, RepeatMax
define('SMART_EVENT_UPDATE_OOC',              1);    // InitialMin, InitialMax, RepeatMin, RepeatMax
define('SMART_EVENT_HEALT_PCT',               2);    // HPMin%, HPMax%,  RepeatMin, RepeatMax
define('SMART_EVENT_MANA_PCT',                3);    // ManaMin%, ManaMax%, RepeatMin, RepeatMax
define('SMART_EVENT_AGGRO',                   4);    // NONE
define('SMART_EVENT_KILL',                    5);    // CooldownMin0, CooldownMax1, playerOnly2, else creature entry3
define('SMART_EVENT_DEATH',                   6);    // NONE
define('SMART_EVENT_EVADE',                   7);    // NONE
define('SMART_EVENT_SPELLHIT',                8);    // SpellID, School, CooldownMin, CooldownMax
define('SMART_EVENT_RANGE',                   9);    // MinDist, MaxDist, RepeatMin, RepeatMax
define('SMART_EVENT_OOC_LOS',                 10);   // NoHostile, MaxRnage, CooldownMin, CooldownMax
define('SMART_EVENT_RESPAWN',                 11);   // type, MapId, ZoneId
define('SMART_EVENT_TARGET_HEALTH_PCT',       12);   // HPMin%, HPMax%, RepeatMin, RepeatMax
define('SMART_EVENT_TARGET_CASTING',          13);   // RepeatMin, RepeatMax
define('SMART_EVENT_FRIENDLY_HEALTH',         14);   // HPDeficit, Radius, RepeatMin, RepeatMax
define('SMART_EVENT_FRIENDLY_IS_CC',          15);   // Radius, RepeatMin, RepeatMax
define('SMART_EVENT_FRIENDLY_MISSING_BUFF',   16);   // SpellId, Radius, RepeatMin, RepeatMax
define('SMART_EVENT_SUMMONED_UNIT',           17);   // CreatureId(0 all), CooldownMin, CooldownMax
define('SMART_EVENT_TARGET_MANA_PCT',         18);   // ManaMin%, ManaMax%, RepeatMin, RepeatMax
define('SMART_EVENT_ACCEPTED_QUEST',          19);   // QuestID(0any)
define('SMART_EVENT_REWARD_QUEST',            20);   // QuestID(0any)
define('SMART_EVENT_REACHED_HOME',            21);   // NONE
define('SMART_EVENT_RECEIVE_EMOTE',           22);   // EmoteId, CooldownMin, CooldownMax, condition, val1, val2, val3
define('SMART_EVENT_HAS_AURA',                23);   // Param1 = SpellID, Param2 = Number of Time STacked, Param3/4 RepeatMin, RepeatMax
define('SMART_EVENT_TARGET_BUFFED',           24);   // Param1 = SpellID, Param2 = Number of Time STacked, Param3/4 RepeatMin, RepeatMax
define('SMART_EVENT_RESET',                   25);   // Called after combat, when the creature respawn and spawn.
define('SMART_EVENT_IC_LOS',                  26);   // NoHostile, MaxRnage, CooldownMin, CooldownMax
define('SMART_EVENT_PASSENGER_BOARDED',       27);   // CooldownMin, CooldownMax
define('SMART_EVENT_PASSENGER_REMOVED',       28);   // CooldownMin, CooldownMax
define('SMART_EVENT_CHARMED',                 29);   // NONE
define('SMART_EVENT_CHARMED_TARGET',          30);   // NONE
define('SMART_EVENT_SPELLHIT_TARGET',         31);   // SpellID, School, CooldownMin, CooldownMax
define('SMART_EVENT_DAMAGED',                 32);   // MinDmg, MaxDmg, CooldownMin, CooldownMax
define('SMART_EVENT_DAMAGED_TARGET',          33);   // MinDmg, MaxDmg, CooldownMin, CooldownMax
define('SMART_EVENT_MOVEMENTINFORM',          34);   // MovementType(any), PointID
define('SMART_EVENT_SUMMON_DESPAWNED',        35);   // Entry, CooldownMin, CooldownMax
define('SMART_EVENT_CORPSE_REMOVED',          36);   // NONE
define('SMART_EVENT_AI_INIT',                 37);   // NONE
define('SMART_EVENT_DATA_SET',                38);   // Id, Value, CooldownMin, CooldownMax
define('SMART_EVENT_WAYPOINT_START',          39);   // PointId(0any), pathID(0any)
define('SMART_EVENT_WAYPOINT_REACHED',        40);   // PointId(0any), pathID(0any)
define('SMART_EVENT_TRANSPORT_ADDPLAYER',     41);   // NONE
define('SMART_EVENT_TRANSPORT_ADDCREATURE',   42);   // Entry (0 any)
define('SMART_EVENT_TRANSPORT_REMOVE_PLAYER', 43);   // NONE
define('SMART_EVENT_TRANSPORT_RELOCATE',      44);   // PointId
define('SMART_EVENT_INSTANCE_PLAYER_ENTER',   45);   // Team (0 any), CooldownMin, CooldownMax
define('SMART_EVENT_AREATRIGGER_ONTRIGGER',   46);   // TriggerId(0 any)
define('SMART_EVENT_QUEST_ACCEPTED',          47);   // none
define('SMART_EVENT_QUEST_OBJ_COPLETETION',   48);   // none
define('SMART_EVENT_QUEST_COMPLETION',        49);   // none
define('SMART_EVENT_QUEST_REWARDED',          50);   // none
define('SMART_EVENT_QUEST_FAIL',              51);   // none
define('SMART_EVENT_TEXT_OVER',               52);   // GroupId from creature_text,  creature entry who talks (0 any)
define('SMART_EVENT_RECEIVE_HEAL',            53);   // MinHeal, MaxHeal, CooldownMin, CooldownMax
define('SMART_EVENT_JUST_SUMMONED',           54);   // none
define('SMART_EVENT_WAYPOINT_PAUSED',         55);   // PointId(0any), pathID(0any)
define('SMART_EVENT_WAYPOINT_RESUMED',        56);   // PointId(0any), pathID(0any)
define('SMART_EVENT_WAYPOINT_STOPPED',        57);   // PointId(0any), pathID(0any)
define('SMART_EVENT_WAYPOINT_ENDED',          58);   // PointId(0any), pathID(0any)
define('SMART_EVENT_TIMED_EVENT_TRIGGERED',   59);   // id
define('SMART_EVENT_UPDATE',                  60);   // InitialMin, InitialMax, RepeatMin, RepeatMax
define('SMART_EVENT_LINK',                    61);   // INTERNAL USAGE, no params, used to link together multiple events, does not use any extra resources to iterate event lists needlessly
define('SMART_EVENT_GOSSIP_SELECT',           62);   // menuID, actionID
define('SMART_EVENT_JUST_CREATED',            63);   // none
define('SMART_EVENT_GOSSIP_HELLO',            64);   // none
define('SMART_EVENT_FOLLOW_COMPLETED',        65);   // none
define('SMART_EVENT_DUMMY_EFFECT',            66);   // spellId, effectIndex
define('SMART_EVENT_IS_BEHIND_TARGET',        67);   // cooldownMin, CooldownMax
define('SMART_EVENT_GAME_EVENT_START',        68);   // game_event.Entry
define('SMART_EVENT_GAME_EVENT_END',          69);   // game_event.Entry
define('SMART_EVENT_GO_STATE_CHANGED',        70);   //                 go state
define('SMART_EVENT_END',                     71);

define('SMART_EVENT_FLAG_NOT_REPEATABLE',     0x001); // Event can not repeat
define('SMART_EVENT_FLAG_DIFFICULTY_0',       0x002); // Event only occurs in instance difficulty 0
define('SMART_EVENT_FLAG_DIFFICULTY_1',       0x004); // Event only occurs in instance difficulty 1
define('SMART_EVENT_FLAG_DIFFICULTY_2',       0x008); // Event only occurs in instance difficulty 2
define('SMART_EVENT_FLAG_DIFFICULTY_3',       0x010); // Event only occurs in instance difficulty 3
define('SMART_EVENT_FLAG_RESERVED_5',         0x020);
define('SMART_EVENT_FLAG_RESERVED_6',         0x040);
define('SMART_EVENT_FLAG_DEBUG_ONLY',         0x080); // Event only occurs in debug build
define('SMART_EVENT_FLAG_DONT_RESET',         0x100); // Event will not reset in SmartScript::OnReset()

define('SMART_EVENT_FLAG_DIFFICULTY_ALL',     (SMART_EVENT_FLAG_DIFFICULTY_0|SMART_EVENT_FLAG_DIFFICULTY_1|SMART_EVENT_FLAG_DIFFICULTY_2|SMART_EVENT_FLAG_DIFFICULTY_3));
define('SMART_EVENT_FLAGS_ALL',               (SMART_EVENT_FLAG_NOT_REPEATABLE|SMART_EVENT_FLAG_DIFFICULTY_ALL|SMART_EVENT_FLAG_RESERVED_5|SMART_EVENT_FLAG_RESERVED_6|SMART_EVENT_FLAG_DEBUG_ONLY|SMART_EVENT_FLAG_DONT_RESET));

define('SMART_ACTION_NONE',                               0);  // No action
define('SMART_ACTION_TALK',                               1);  // groupID from creature_text, duration to wait before TEXT_OVER event is triggered
define('SMART_ACTION_SET_FACTION',                        2);  // FactionId (or 0 for default)
define('SMART_ACTION_MORPH_TO_ENTRY_OR_MODEL',            3);  // Creature_template entry(param1) OR ModelId (param2) (or 0 for both to demorph)
define('SMART_ACTION_SOUND',                              4);  // SoundId, TextRange
define('SMART_ACTION_PLAY_EMOTE',                         5);  // EmoteId
define('SMART_ACTION_FAIL_QUEST',                         6);  // QuestID
define('SMART_ACTION_ADD_QUEST',                          7);  // QuestID
define('SMART_ACTION_SET_REACT_STATE',                    8);  // state
define('SMART_ACTION_ACTIVATE_GOBJECT',                   9);  //
define('SMART_ACTION_RANDOM_EMOTE',                       10); // EmoteId1, EmoteId2, EmoteId3...
define('SMART_ACTION_CAST',                               11); // SpellId, CastFlags
define('SMART_ACTION_SUMMON_CREATURE',                    12); // CreatureID, summonType, duration in ms, storageID, attackInvoker,
define('SMART_ACTION_THREAT_SINGLE_PCT',                  13); // Threat%
define('SMART_ACTION_THREAT_ALL_PCT',                     14); // Threat%
define('SMART_ACTION_CALL_AREAEXPLOREDOREVENTHAPPENS',    15); // QuestID
define('SMART_ACTION_SEND_CASTCREATUREORGO',              16); // QuestID, SpellId
define('SMART_ACTION_SET_EMOTE_STATE',                    17); // emoteID
define('SMART_ACTION_SET_UNIT_FLAG',                      18); // Flags (may be more than one field OR'd together), Target
define('SMART_ACTION_REMOVE_UNIT_FLAG',                   19); // Flags (may be more than one field OR'd together), Target
define('SMART_ACTION_AUTO_ATTACK',                        20); // AllowAttackState (0 = stop attack, anything else means continue attacking)
define('SMART_ACTION_ALLOW_COMBAT_MOVEMENT',              21); // AllowCombatMovement (0 = stop combat based movement, anything else continue attacking)
define('SMART_ACTION_SET_EVENT_PHASE',                    22); // Phase
define('SMART_ACTION_INC_EVENT_PHASE',                    23); // Value (may be negative to decrement phase, should not be 0)
define('SMART_ACTION_EVADE',                              24); // No Params
define('SMART_ACTION_FLEE_FOR_ASSIST',                    25); // With Emote
define('SMART_ACTION_CALL_GROUPEVENTHAPPENS',             26); // QuestID
define('SMART_ACTION_CALL_CASTEDCREATUREORGO',            27); // CreatureId, SpellId
define('SMART_ACTION_REMOVEAURASFROMSPELL',               28); // Spellid
define('SMART_ACTION_FOLLOW',                             29); // Distance (0 = default), Angle (0 = default), EndCreatureEntry, credit, creditType (0monsterkill, 1event)
define('SMART_ACTION_RANDOM_PHASE',                       30); // PhaseId1, PhaseId2, PhaseId3...
define('SMART_ACTION_RANDOM_PHASE_RANGE',                 31); // PhaseMin, PhaseMax
define('SMART_ACTION_RESET_GOBJECT',                      32); //
define('SMART_ACTION_CALL_KILLEDMONSTER',                 33); // CreatureId,
define('SMART_ACTION_SET_INST_DATA',                      34); // Field, Data
define('SMART_ACTION_SET_INST_DATA64',                    35); // Field,
define('SMART_ACTION_UPDATE_TEMPLATE',                    36); // Entry, Team
define('SMART_ACTION_DIE',                                37); // No Params
define('SMART_ACTION_SET_IN_COMBAT_WITH_ZONE',            38); // No Params
define('SMART_ACTION_CALL_FOR_HELP',                      39); // Radius
define('SMART_ACTION_SET_SHEATH',                         40); // Sheath (0-unarmed, 1-melee, 2-ranged)
define('SMART_ACTION_FORCE_DESPAWN',                      41); // timer
define('SMART_ACTION_SET_INVINCIBILITY_HP_LEVEL',         42); // MinHpValue(+pct, -flat)
define('SMART_ACTION_MOUNT_TO_ENTRY_OR_MODEL',            43); // Creature_template entry(param1) OR ModelId (param2) (or 0 for both to dismount)
define('SMART_ACTION_SET_INGAME_PHASE_MASK',              44); // mask
define('SMART_ACTION_SET_DATA',                           45); // Field, Data (only creature TODO)
define('SMART_ACTION_MOVE_FORWARD',                       46); // distance
define('SMART_ACTION_SET_VISIBILITY',                     47); // on/off
define('SMART_ACTION_SET_ACTIVE',                         48); // No Params
define('SMART_ACTION_ATTACK_START',                       49); //
define('SMART_ACTION_SUMMON_GO',                          50); // GameObjectID, DespawnTime in ms,
define('SMART_ACTION_KILL_UNIT',                          51); //
define('SMART_ACTION_ACTIVATE_TAXI',                      52); // TaxiID
define('SMART_ACTION_WP_START',                           53); // run/walk, pathID, canRepeat, quest, despawntime, reactState
define('SMART_ACTION_WP_PAUSE',                           54); // time
define('SMART_ACTION_WP_STOP',                            55); // despawnTime, quest, fail?
define('SMART_ACTION_ADD_ITEM',                           56); // itemID, count
define('SMART_ACTION_REMOVE_ITEM',                        57); // itemID, count
define('SMART_ACTION_INSTALL_AI_TEMPLATE',                58); // AITemplateID
define('SMART_ACTION_SET_RUN',                            59); // 0/1
define('SMART_ACTION_SET_FLY',                            60); // 0/1
define('SMART_ACTION_SET_SWIM',                           61); // 0/1
define('SMART_ACTION_TELEPORT',                           62); // mapID,
define('SMART_ACTION_STORE_VARIABLE_DECIMAL',             63); // varID, number
define('SMART_ACTION_STORE_TARGET_LIST',                  64); // varID,
define('SMART_ACTION_WP_RESUME',                          65); // none
define('SMART_ACTION_SET_ORIENTATION',                    66); //
define('SMART_ACTION_CREATE_TIMED_EVENT',                 67); // id, InitialMin, InitialMax, RepeatMin(only if it repeats), RepeatMax(only if it repeats), chance
define('SMART_ACTION_PLAYMOVIE',                          68); // entry
define('SMART_ACTION_MOVE_TO_POS',                        69); // PointId, xyz
define('SMART_ACTION_RESPAWN_TARGET',                     70); //
define('SMART_ACTION_EQUIP',                              71); // entry, slotmask slot1, slot2, slot3   , only slots with mask set will be sent to client, bits are 1, 2, 4, leaving mask 0 is defaulted to mask 7 (send all), slots1-3 are only used if no entry is set
define('SMART_ACTION_CLOSE_GOSSIP',                       72); // none
define('SMART_ACTION_TRIGGER_TIMED_EVENT',                73); // id(>1)
define('SMART_ACTION_REMOVE_TIMED_EVENT',                 74); // id(>1)
define('SMART_ACTION_ADD_AURA',                           75); // spellid,  targets
define('SMART_ACTION_OVERRIDE_SCRIPT_BASE_OBJECT',        76); // WARNING: CAN CRASH CORE, do not use if you dont know what you are doing
define('SMART_ACTION_RESET_SCRIPT_BASE_OBJECT',           77); // none
define('SMART_ACTION_CALL_SCRIPT_RESET',                  78); // none
define('SMART_ACTION_SET_RANGED_MOVEMENT',                79); // Attack Distance, Attack Angle
define('SMART_ACTION_CALL_TIMED_ACTIONLIST',              80); // ID (overwrites already running actionlist), stop after combat?(0/1), timer update type(0-OOC, 1-IC, 2-ALWAYS)
define('SMART_ACTION_SET_NPC_FLAG',                       81); // Flags
define('SMART_ACTION_ADD_NPC_FLAG',                       82); // Flags
define('SMART_ACTION_REMOVE_NPC_FLAG',                    83); // Flags
define('SMART_ACTION_SIMPLE_TALK',                        84); // groupID, can be used to make players say groupID, Text_over event is not triggered, whisper can not be used (Target units will say the text)
define('SMART_ACTION_INVOKER_CAST',                       85); // spellID, castFlags,   if avaliable, last used invoker will cast spellId with castFlags on targets
define('SMART_ACTION_CROSS_CAST',                         86); // spellID, castFlags, CasterTargetType, CasterTarget param1, CasterTarget param2, CasterTarget param3, ( + the origonal target fields as Destination target),   CasterTargets will cast spellID on all Targets (use with caution if targeting multiple * multiple units)
define('SMART_ACTION_CALL_RANDOM_TIMED_ACTIONLIST',       87); // script9 ids 1-9
define('SMART_ACTION_CALL_RANDOM_RANGE_TIMED_ACTIONLIST', 88); // script9 id min, max
define('SMART_ACTION_RANDOM_MOVE',                        89); // maxDist
define('SMART_ACTION_SET_UNIT_FIELD_BYTES_1',             90); // bytes, target
define('SMART_ACTION_REMOVE_UNIT_FIELD_BYTES_1',          91); // bytes, target
define('SMART_ACTION_INTERRUPT_SPELL',                    92);
define('SMART_ACTION_SEND_GO_CUSTOM_ANIM',                93); // anim id
define('SMART_ACTION_SET_DYNAMIC_FLAG',                   94); // Flags
define('SMART_ACTION_ADD_DYNAMIC_FLAG',                   95); // Flags
define('SMART_ACTION_REMOVE_DYNAMIC_FLAG',                96); // Flags
define('SMART_ACTION_JUMP_TO_POS',                        97); // speedXY, speedZ, targetX, targetY, targetZ
define('SMART_ACTION_SEND_GOSSIP_MENU',                   98); // menuId, optionId
define('SMART_ACTION_GO_SET_LOOT_STATE',                  99); // state
define('SMART_ACTION_SEND_TARGET_TO_TARGET',              100);// id
define('SMART_ACTION_END',                                101);

define("SMART_TARGET_NONE",                   0);   // NONE, defaulting to invoket
define("SMART_TARGET_SELF",                   1);   // Self cast
define("SMART_TARGET_VICTIM",                 2);   // Our current target (ie: highest aggro)
define("SMART_TARGET_HOSTILE_SECOND_AGGRO",   3);   // Second highest aggro
define("SMART_TARGET_HOSTILE_LAST_AGGRO",     4);   // Dead last on aggro
define("SMART_TARGET_HOSTILE_RANDOM",         5);   // Just any random target on our threat list
define("SMART_TARGET_HOSTILE_RANDOM_NOT_TOP", 6);   // Any random target except top threat
define("SMART_TARGET_ACTION_INVOKER",         7);   // Unit who caused this Event to occur
define("SMART_TARGET_POSITION",               8);   // use xyz from event params
define("SMART_TARGET_CREATURE_RANGE",         9);   // CreatureEntry(0any), minDist, maxDist
define("SMART_TARGET_CREATURE_GUID",          10);  // guid, entry
define("SMART_TARGET_CREATURE_DISTANCE",      11);  // CreatureEntry(0any), maxDist
define("SMART_TARGET_STORED",                 12);  // id, uses pre-stored target(list)
define("SMART_TARGET_GAMEOBJECT_RANGE",       13);  // entry(0any), min, max
define("SMART_TARGET_GAMEOBJECT_GUID",        14);  // guid, entry
define("SMART_TARGET_GAMEOBJECT_DISTANCE",    15);  // entry(0any), maxDist
define("SMART_TARGET_INVOKER_PARTY",          16);  // invoker's party members
define("SMART_TARGET_PLAYER_RANGE",           17);  // min, max
define("SMART_TARGET_PLAYER_DISTANCE",        18);  // maxDist
define("SMART_TARGET_CLOSEST_CREATURE",       19);  // CreatureEntry(0any), maxDist, dead?
define("SMART_TARGET_CLOSEST_GAMEOBJECT",     20);  // entry(0any), maxDist
define("SMART_TARGET_CLOSEST_PLAYER",         21);  // maxDist
define("SMART_TARGET_ACTION_INVOKER_VEHICLE", 22);  // Unit's vehicle who caused this Event to occur
define("SMART_TARGET_OWNER_OR_SUMMONER",      23);  // Unit's owner or summoner
define("SMART_TARGET_THREAT_LIST",            24);  // All units on creature's threat list
define("SMART_TARGET_END",                    25);
