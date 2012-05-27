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