<?php
namespace DBCSearcher;

class DefineHolder {
    public function __construct() { }
    
    public function createDefine($fieldName, $value) {
        define($fieldName, $value);
        $this->recentMade[$fieldName] = $value;
    }
    
    public function createDefines($array) {
        foreach ($array as $k => $v) {
            $this->createDefine($k, $v);
        }
    }
    
    public function pushToArray(&$out)
    {
        $out = $this->recentMade;
        unset($this->recentMade);
    }
}

$defineMap = new DefineHolder();
$defineMap->createDefines(array(
    'SPELL_SCHOOL_NORMAL' => 0,
    'SPELL_SCHOOL_HOLY'   => 1,
    'SPELL_SCHOOL_FIRE'   => 2,
    'SPELL_SCHOOL_NATURE' => 3,
    'SPELL_SCHOOL_FROST'  => 4,
    'SPELL_SCHOOL_SHADOW' => 5,
    'SPELL_SCHOOL_ARCANE' => 6,
    
    'SPELL_SCHOOL_MASK_NONE'   => 0x00,
    'SPELL_SCHOOL_MASK_NORMAL' => 1 << 0,
    'SPELL_SCHOOL_MASK_HOLY'   => 1 << 1,
    'SPELL_SCHOOL_MASK_FIRE'   => 1 << 2,
    'SPELL_SCHOOL_MASK_NATURE' => 1 << 3,
    'SPELL_SCHOOL_MASK_FROST'  => 1 << 4,
    'SPELL_SCHOOL_MASK_SHADOW' => 1 << 5,
    'SPELL_SCHOOL_MASK_ARCANE' => 1 << 6,
));
$defineMap->pushToArray($enumSchoolMasks);

$defineMap->createDefines(array(
    'FORM_ALL' =>                -1,
    'FORM_NONE' =>               0,
    'FORM_CAT' =>                1 << 0x00,    // 1
    'FORM_TREE' =>               1 << 0x01,    // 2
    'FORM_TRAVEL' =>             1 << 0x02,    // 3
    'FORM_AQUA' =>               1 << 0x03,    // 4
    'FORM_BEAR' =>               1 << 0x04,    // 5
    'FORM_AMBIENT' =>            1 << 0x05,    // 6
    'FORM_GHOUL' =>              1 << 0x06,    // 7
    'FORM_DIREBEAR' =>           1 << 0x07,    // 8
    'FORM_STEVES_GHOUL' =>       1 << 0x08,    // 9
    'FORM_THARONJA_SKELETON' =>  1 << 0x09,    // 10
    'FORM_TEST_OF_STRENGTH' =>   1 << 0x0A,    // 11
    'FORM_BLB_PLAYER' =>         1 << 0x0B,    // 12
    'FORM_SHADOW_DANCE' =>       1 << 0x0C,    // 13
    'FORM_CREATUREBEAR' =>       1 << 0x0D,    // 14
    'FORM_CREATURECAT' =>        1 << 0x0E,    // 15
    'FORM_GHOSTWOLF' =>          1 << 0x0F,    // 16
    'FORM_BATTLESTANCE' =>       1 << 0x10,    // 17
    'FORM_DEFENSIVESTANCE' =>    1 << 0x11,    // 18
    'FORM_BERSERKERSTANCE' =>    1 << 0x12,    // 19
    'FORM_TEST' =>               1 << 0x13,    // 20
    'FORM_ZOMBIE' =>             1 << 0x14,    // 21
    'FORM_METAMORPHOSIS' =>      1 << 0x15,    // 22
    'FORM_UNK1' =>               1 << 0x16,    // 23
    'FORM_UNK2' =>               1 << 0x17,    // 24
    'FORM_UNDEAD' =>             1 << 0x18,    // 25
    'FORM_FRENZY' =>             1 << 0x19,    // 26
    'FORM_FLIGHT_EPIC' =>        1 << 0x1A,    // 27
    'FORM_SHADOW' =>             1 << 0x1B,    // 28
    'FORM_FLIGHT' =>             1 << 0x1C,    // 29
    'FORM_STEALTH' =>            1 << 0x1D,    // 30
    'FORM_MOONKIN' =>            1 << 0x1E,    // 31
    'FORM_SPIRITOFREDEMPTION' => 1 << 0x1F     // 32
));
$defineMap->pushToArray($enumStances);

// Spell Family Names
$defineMap->createDefines(array(
    'SPELLFAMILY_GENERIC'     => 0,
    'SPELLFAMILY_UNK1'        => 1,// events, holidays
    'SPELLFAMILY_MAGE'        => 3,
    'SPELLFAMILY_WARRIOR'     => 4,
    'SPELLFAMILY_WARLOCK'     => 5,
    'SPELLFAMILY_PRIEST'      => 6,
    'SPELLFAMILY_DRUID'       => 7,
    'SPELLFAMILY_ROGUE'       => 8,
    'SPELLFAMILY_HUNTER'      => 9,
    'SPELLFAMILY_PALADIN'     => 10,
    'SPELLFAMILY_SHAMAN'      => 11,
    'SPELLFAMILY_UNK2'        => 12,// 2 spells (silence resistance)
    'SPELLFAMILY_POTION'      => 13,
    'SPELLFAMILY_DEATHKNIGHT' => 15,
    'SPELLFAMILY_PET'         => 17,
));
$defineMap->pushToArray($enumSpellFamily);

$defineMap->createDefines(array(
    'SPELL_AURA_NONE'=> 0,
    'SPELL_AURA_BIND_SIGHT'=> 1,
    'SPELL_AURA_MOD_POSSESS'=> 2,
    'SPELL_AURA_PERIODIC_DAMAGE'=> 3,
    'SPELL_AURA_DUMMY'=> 4,
    'SPELL_AURA_MOD_CONFUSE'=> 5,
    'SPELL_AURA_MOD_CHARM'=> 6,
    'SPELL_AURA_MOD_FEAR'=> 7,
    'SPELL_AURA_PERIODIC_HEAL'=> 8,
    'SPELL_AURA_MOD_ATTACKSPEED'=> 9,
    'SPELL_AURA_MOD_THREAT'=> 10,
    'SPELL_AURA_MOD_TAUNT'=> 11,
    'SPELL_AURA_MOD_STUN'=> 12,
    'SPELL_AURA_MOD_DAMAGE_DONE'=> 13,
    'SPELL_AURA_MOD_DAMAGE_TAKEN'=> 14,
    'SPELL_AURA_DAMAGE_SHIELD'=> 15,
    'SPELL_AURA_MOD_STEALTH'=> 16,
    'SPELL_AURA_MOD_STEALTH_DETECT'=> 17,
    'SPELL_AURA_MOD_INVISIBILITY'=> 18,
    'SPELL_AURA_MOD_INVISIBILITY_DETECT'=> 19,
    'SPELL_AURA_OBS_MOD_HEALTH'=> 20,
    'SPELL_AURA_OBS_MOD_POWER'=> 21,
    'SPELL_AURA_MOD_RESISTANCE'=> 22,
    'SPELL_AURA_PERIODIC_TRIGGER_SPELL'=> 23,
    'SPELL_AURA_PERIODIC_ENERGIZE'=> 24,
    'SPELL_AURA_MOD_PACIFY'=> 25,
    'SPELL_AURA_MOD_ROOT'=> 26,
    'SPELL_AURA_MOD_SILENCE'=> 27,
    'SPELL_AURA_REFLECT_SPELLS'=> 28,
    'SPELL_AURA_MOD_STAT'=> 29,
    'SPELL_AURA_MOD_SKILL'=> 30,
    'SPELL_AURA_MOD_INCREASE_SPEED'=> 31,
    'SPELL_AURA_MOD_INCREASE_MOUNTED_SPEED'=> 32,
    'SPELL_AURA_MOD_DECREASE_SPEED'=> 33,
    'SPELL_AURA_MOD_INCREASE_HEALTH'=> 34,
    'SPELL_AURA_MOD_INCREASE_ENERGY'=> 35,
    'SPELL_AURA_MOD_SHAPESHIFT'=> 36,
    'SPELL_AURA_EFFECT_IMMUNITY'=> 37,
    'SPELL_AURA_STATE_IMMUNITY'=> 38,
    'SPELL_AURA_SCHOOL_IMMUNITY'=> 39,
    'SPELL_AURA_DAMAGE_IMMUNITY'=> 40,
    'SPELL_AURA_DISPEL_IMMUNITY'=> 41,
    'SPELL_AURA_PROC_TRIGGER_SPELL'=> 42,
    'SPELL_AURA_PROC_TRIGGER_DAMAGE'=> 43,
    'SPELL_AURA_TRACK_CREATURES'=> 44,
    'SPELL_AURA_TRACK_RESOURCES'=> 45,
    'SPELL_AURA_46'=> 46,                                    // Ignore all Gear test spells
    'SPELL_AURA_MOD_PARRY_PERCENT'=> 47,
    'SPELL_AURA_48'=> 48,                                    // One periodic spell
    'SPELL_AURA_MOD_DODGE_PERCENT'=> 49,
    'SPELL_AURA_MOD_CRITICAL_HEALING_AMOUNT'=> 50,
    'SPELL_AURA_MOD_BLOCK_PERCENT'=> 51,
    'SPELL_AURA_MOD_WEAPON_CRIT_PERCENT'=> 52,
    'SPELL_AURA_PERIODIC_LEECH'=> 53,
    'SPELL_AURA_MOD_HIT_CHANCE'=> 54,
    'SPELL_AURA_MOD_SPELL_HIT_CHANCE'=> 55,
    'SPELL_AURA_TRANSFORM'=> 56,
    'SPELL_AURA_MOD_SPELL_CRIT_CHANCE'=> 57,
    'SPELL_AURA_MOD_INCREASE_SWIM_SPEED'=> 58,
    'SPELL_AURA_MOD_DAMAGE_DONE_CREATURE'=> 59,
    'SPELL_AURA_MOD_PACIFY_SILENCE'=> 60,
    'SPELL_AURA_MOD_SCALE'=> 61,
    'SPELL_AURA_PERIODIC_HEALTH_FUNNEL'=> 62,
    'SPELL_AURA_63'=> 63,                                    // old define('SPELL_AURA_PERIODIC_MANA_FUNNEL'
    'SPELL_AURA_PERIODIC_MANA_LEECH'=> 64,
    'SPELL_AURA_MOD_CASTING_SPEED_NOT_STACK'=> 65,
    'SPELL_AURA_FEIGN_DEATH'=> 66,
    'SPELL_AURA_MOD_DISARM'=> 67,
    'SPELL_AURA_MOD_STALKED'=> 68,
    'SPELL_AURA_SCHOOL_ABSORB'=> 69,
    'SPELL_AURA_EXTRA_ATTACKS'=> 70,
    'SPELL_AURA_MOD_SPELL_CRIT_CHANCE_SCHOOL'=> 71,
    'SPELL_AURA_MOD_POWER_COST_SCHOOL_PCT'=> 72,
    'SPELL_AURA_MOD_POWER_COST_SCHOOL'=> 73,
    'SPELL_AURA_REFLECT_SPELLS_SCHOOL'=> 74,
    'SPELL_AURA_MOD_LANGUAGE'=> 75,
    'SPELL_AURA_FAR_SIGHT'=> 76,
    'SPELL_AURA_MECHANIC_IMMUNITY'=> 77,
    'SPELL_AURA_MOUNTED'=> 78,
    'SPELL_AURA_MOD_DAMAGE_PERCENT_DONE'=> 79,
    'SPELL_AURA_MOD_PERCENT_STAT'=> 80,
    'SPELL_AURA_SPLIT_DAMAGE_PCT'=> 81,
    'SPELL_AURA_WATER_BREATHING'=> 82,
    'SPELL_AURA_MOD_BASE_RESISTANCE'=> 83,
    'SPELL_AURA_MOD_REGEN'=> 84,
    'SPELL_AURA_MOD_POWER_REGEN'=> 85,
    'SPELL_AURA_CHANNEL_DEATH_ITEM'=> 86,
    'SPELL_AURA_MOD_DAMAGE_PERCENT_TAKEN'=> 87,
    'SPELL_AURA_MOD_HEALTH_REGEN_PERCENT'=> 88,
    'SPELL_AURA_PERIODIC_DAMAGE_PERCENT'=> 89,
    'SPELL_AURA_90'=> 90,                                    // old define('SPELL_AURA_MOD_RESIST_CHANCE'
    'SPELL_AURA_MOD_DETECT_RANGE'=> 91,
    'SPELL_AURA_PREVENTS_FLEEING'=> 92,
    'SPELL_AURA_MOD_UNATTACKABLE'=> 93,
    'SPELL_AURA_INTERRUPT_REGEN'=> 94,
    'SPELL_AURA_GHOST'=> 95,
    'SPELL_AURA_SPELL_MAGNET'=> 96,
    'SPELL_AURA_MANA_SHIELD'=> 97,
    'SPELL_AURA_MOD_SKILL_TALENT'=> 98,
    'SPELL_AURA_MOD_ATTACK_POWER'=> 99,
    'SPELL_AURA_AURAS_VISIBLE'=> 100,
    'SPELL_AURA_MOD_RESISTANCE_PCT'=> 101,
    'SPELL_AURA_MOD_MELEE_ATTACK_POWER_VERSUS'=> 102,
    'SPELL_AURA_MOD_TOTAL_THREAT'=> 103,
    'SPELL_AURA_WATER_WALK'=> 104,
    'SPELL_AURA_FEATHER_FALL'=> 105,
    'SPELL_AURA_HOVER'=> 106,
    'SPELL_AURA_ADD_FLAT_MODIFIER'=> 107,
    'SPELL_AURA_ADD_PCT_MODIFIER'=> 108,
    'SPELL_AURA_ADD_TARGET_TRIGGER'=> 109,
    'SPELL_AURA_MOD_POWER_REGEN_PERCENT'=> 110,
    'SPELL_AURA_ADD_CASTER_HIT_TRIGGER'=> 111,
    'SPELL_AURA_OVERRIDE_CLASS_SCRIPTS'=> 112,
    'SPELL_AURA_MOD_RANGED_DAMAGE_TAKEN'=> 113,
    'SPELL_AURA_MOD_RANGED_DAMAGE_TAKEN_PCT'=> 114,
    'SPELL_AURA_MOD_HEALING'=> 115,
    'SPELL_AURA_MOD_REGEN_DURING_COMBAT'=> 116,
    'SPELL_AURA_MOD_MECHANIC_RESISTANCE'=> 117,
    'SPELL_AURA_MOD_HEALING_PCT'=> 118,
    'SPELL_AURA_119'=> 119,                                  // old define('SPELL_AURA_SHARE_PET_TRACKING'
    'SPELL_AURA_UNTRACKABLE'=> 120,
    'SPELL_AURA_EMPATHY'=> 121,
    'SPELL_AURA_MOD_OFFHAND_DAMAGE_PCT'=> 122,
    'SPELL_AURA_MOD_TARGET_RESISTANCE'=> 123,
    'SPELL_AURA_MOD_RANGED_ATTACK_POWER'=> 124,
    'SPELL_AURA_MOD_MELEE_DAMAGE_TAKEN'=> 125,
    'SPELL_AURA_MOD_MELEE_DAMAGE_TAKEN_PCT'=> 126,
    'SPELL_AURA_RANGED_ATTACK_POWER_ATTACKER_BONUS'=> 127,
    'SPELL_AURA_MOD_POSSESS_PET'=> 128,
    'SPELL_AURA_MOD_SPEED_ALWAYS'=> 129,
    'SPELL_AURA_MOD_MOUNTED_SPEED_ALWAYS'=> 130,
    'SPELL_AURA_MOD_RANGED_ATTACK_POWER_VERSUS'=> 131,
    'SPELL_AURA_MOD_INCREASE_ENERGY_PERCENT'=> 132,
    'SPELL_AURA_MOD_INCREASE_HEALTH_PERCENT'=> 133,
    'SPELL_AURA_MOD_MANA_REGEN_INTERRUPT'=> 134,
    'SPELL_AURA_MOD_HEALING_DONE'=> 135,
    'SPELL_AURA_MOD_HEALING_DONE_PERCENT'=> 136,
    'SPELL_AURA_MOD_TOTAL_STAT_PERCENTAGE'=> 137,
    'SPELL_AURA_MOD_MELEE_HASTE'=> 138,
    'SPELL_AURA_FORCE_REACTION'=> 139,
    'SPELL_AURA_MOD_RANGED_HASTE'=> 140,
    'SPELL_AURA_MOD_RANGED_AMMO_HASTE'=> 141,
    'SPELL_AURA_MOD_BASE_RESISTANCE_PCT'=> 142,
    'SPELL_AURA_MOD_RESISTANCE_EXCLUSIVE'=> 143,
    'SPELL_AURA_SAFE_FALL'=> 144,
    'SPELL_AURA_MOD_PET_TALENT_POINTS'=> 145,
    'SPELL_AURA_ALLOW_TAME_PET_TYPE'=> 146,
    'SPELL_AURA_MECHANIC_IMMUNITY_MASK'=> 147,
    'SPELL_AURA_RETAIN_COMBO_POINTS'=> 148,
    'SPELL_AURA_REDUCE_PUSHBACK'=> 149,                     //    Reduce Pushback
    'SPELL_AURA_MOD_SHIELD_BLOCKVALUE_PCT'=> 150,
    'SPELL_AURA_TRACK_STEALTHED'=> 151,                     //    Track Stealthed
    'SPELL_AURA_MOD_DETECTED_RANGE'=> 152,                   //    Mod Detected Range
    'SPELL_AURA_SPLIT_DAMAGE_FLAT'=> 153,                    //    Split Damage Flat
    'SPELL_AURA_MOD_STEALTH_LEVEL'=> 154,                    //    Stealth Level Modifier
    'SPELL_AURA_MOD_WATER_BREATHING'=> 155,                  //    Mod Water Breathing
    'SPELL_AURA_MOD_REPUTATION_GAIN'=> 156,                  //    Mod Reputation Gain
    'SPELL_AURA_PET_DAMAGE_MULTI'=> 157,                     //    Mod Pet Damage
    'SPELL_AURA_MOD_SHIELD_BLOCKVALUE'=> 158,
    'SPELL_AURA_NO_PVP_CREDIT'=> 159,
    'SPELL_AURA_MOD_AOE_AVOIDANCE'=> 160,
    'SPELL_AURA_MOD_HEALTH_REGEN_IN_COMBAT'=> 161,
    'SPELL_AURA_POWER_BURN_MANA'=> 162,
    'SPELL_AURA_MOD_CRIT_DAMAGE_BONUS_MELEE'=> 163,
    'SPELL_AURA_164'=> 164,
    'SPELL_AURA_MELEE_ATTACK_POWER_ATTACKER_BONUS'=> 165,
    'SPELL_AURA_MOD_ATTACK_POWER_PCT'=> 166,
    'SPELL_AURA_MOD_RANGED_ATTACK_POWER_PCT'=> 167,
    'SPELL_AURA_MOD_DAMAGE_DONE_VERSUS'=> 168,
    'SPELL_AURA_MOD_CRIT_PERCENT_VERSUS'=> 169,
    'SPELL_AURA_DETECT_AMORE'=> 170,
    'SPELL_AURA_MOD_SPEED_NOT_STACK'=> 171,
    'SPELL_AURA_MOD_MOUNTED_SPEED_NOT_STACK'=> 172,
    'SPELL_AURA_173'=> 173,                                  // old define('SPELL_AURA_ALLOW_CHAMPION_SPELLS'
    'SPELL_AURA_MOD_SPELL_DAMAGE_OF_STAT_PERCENT'=> 174,     // by defeult intelect, dependent from define('SPELL_AURA_MOD_SPELL_HEALING_OF_STAT_PERCENT'
    'SPELL_AURA_MOD_SPELL_HEALING_OF_STAT_PERCENT'=> 175,
    'SPELL_AURA_SPIRIT_OF_REDEMPTION'=> 176,
    'SPELL_AURA_AOE_CHARM'=> 177,
    'SPELL_AURA_MOD_DEBUFF_RESISTANCE'=> 178,
    'SPELL_AURA_MOD_ATTACKER_SPELL_CRIT_CHANCE'=> 179,
    'SPELL_AURA_MOD_FLAT_SPELL_DAMAGE_VERSUS'=> 180,
    'SPELL_AURA_181'=> 181,                                  // old define('SPELL_AURA_MOD_FLAT_SPELL_CRIT_DAMAGE_VERSUS' - possible flat spell crit damage versus
    'SPELL_AURA_MOD_RESISTANCE_OF_STAT_PERCENT'=> 182,
    'SPELL_AURA_MOD_CRITICAL_THREAT'=> 183,
    'SPELL_AURA_MOD_ATTACKER_MELEE_HIT_CHANCE'=> 184,
    'SPELL_AURA_MOD_ATTACKER_RANGED_HIT_CHANCE'=> 185,
    'SPELL_AURA_MOD_ATTACKER_SPELL_HIT_CHANCE'=> 186,
    'SPELL_AURA_MOD_ATTACKER_MELEE_CRIT_CHANCE'=> 187,
    'SPELL_AURA_MOD_ATTACKER_RANGED_CRIT_CHANCE'=> 188,
    'SPELL_AURA_MOD_RATING'=> 189,
    'SPELL_AURA_MOD_FACTION_REPUTATION_GAIN'=> 190,
    'SPELL_AURA_USE_NORMAL_MOVEMENT_SPEED'=> 191,
    'SPELL_AURA_MOD_MELEE_RANGED_HASTE'=> 192,
    'SPELL_AURA_MELEE_SLOW'=> 193,
    'SPELL_AURA_MOD_TARGET_ABSORB_SCHOOL'=> 194,
    'SPELL_AURA_MOD_TARGET_ABILITY_ABSORB_SCHOOL'=> 195,
    'SPELL_AURA_MOD_COOLDOWN'=> 196,                         // only 24818 Noxious Breath
    'SPELL_AURA_MOD_ATTACKER_SPELL_AND_WEAPON_CRIT_CHANCE'=> 197,
    'SPELL_AURA_198'=> 198,                                  // old define('SPELL_AURA_MOD_ALL_WEAPON_SKILLS'
    'SPELL_AURA_MOD_INCREASES_SPELL_PCT_TO_HIT'=> 199,
    'SPELL_AURA_MOD_XP_PCT'=> 200,
    'SPELL_AURA_FLY'=> 201,
    'SPELL_AURA_IGNORE_COMBAT_RESULT'=> 202,
    'SPELL_AURA_MOD_ATTACKER_MELEE_CRIT_DAMAGE'=> 203,
    'SPELL_AURA_MOD_ATTACKER_RANGED_CRIT_DAMAGE'=> 204,
    'SPELL_AURA_MOD_SCHOOL_CRIT_DMG_TAKEN'=> 205,
    'SPELL_AURA_MOD_INCREASE_VEHICLE_FLIGHT_SPEED'=> 206,
    'SPELL_AURA_MOD_INCREASE_MOUNTED_FLIGHT_SPEED'=> 207,
    'SPELL_AURA_MOD_INCREASE_FLIGHT_SPEED'=> 208,
    'SPELL_AURA_MOD_MOUNTED_FLIGHT_SPEED_ALWAYS'=> 209,
    'SPELL_AURA_MOD_VEHICLE_SPEED_ALWAYS'=> 210,
    'SPELL_AURA_MOD_FLIGHT_SPEED_NOT_STACK'=> 211,
    'SPELL_AURA_MOD_RANGED_ATTACK_POWER_OF_STAT_PERCENT'=> 212,
    'SPELL_AURA_MOD_RAGE_FROM_DAMAGE_DEALT'=> 213,
    'SPELL_AURA_214'=> 214,
    'SPELL_AURA_ARENA_PREPARATION'=> 215,
    'SPELL_AURA_HASTE_SPELLS'=> 216,
    'SPELL_AURA_217'=> 217,
    'SPELL_AURA_HASTE_RANGED'=> 218,
    'SPELL_AURA_MOD_MANA_REGEN_FROM_STAT'=> 219,
    'SPELL_AURA_MOD_RATING_FROM_STAT'=> 220,
    'SPELL_AURA_MOD_DETAUNT'=> 221,
    'SPELL_AURA_222'=> 222,
    'SPELL_AURA_RAID_PROC_FROM_CHARGE'=> 223,
    'SPELL_AURA_224'=> 224,
    'SPELL_AURA_RAID_PROC_FROM_CHARGE_WITH_VALUE'=> 225,
    'SPELL_AURA_PERIODIC_DUMMY'=> 226,
    'SPELL_AURA_PERIODIC_TRIGGER_SPELL_WITH_VALUE'=> 227,
    'SPELL_AURA_DETECT_STEALTH'=> 228,
    'SPELL_AURA_MOD_AOE_DAMAGE_AVOIDANCE'=> 229,
    'SPELL_AURA_230'=> 230,
    'SPELL_AURA_PROC_TRIGGER_SPELL_WITH_VALUE'=> 231,
    'SPELL_AURA_MECHANIC_DURATION_MOD'=> 232,
    'SPELL_AURA_233'=> 233,
    'SPELL_AURA_MECHANIC_DURATION_MOD_NOT_STACK'=> 234,
    'SPELL_AURA_MOD_DISPEL_RESIST'=> 235,
    'SPELL_AURA_CONTROL_VEHICLE'=> 236,
    'SPELL_AURA_MOD_SPELL_DAMAGE_OF_ATTACK_POWER'=> 237,
    'SPELL_AURA_MOD_SPELL_HEALING_OF_ATTACK_POWER'=> 238,
    'SPELL_AURA_MOD_SCALE_2'=> 239,
    'SPELL_AURA_MOD_EXPERTISE'=> 240,
    'SPELL_AURA_FORCE_MOVE_FORWARD'=> 241,
    'SPELL_AURA_MOD_SPELL_DAMAGE_FROM_HEALING'=> 242,
    'SPELL_AURA_MOD_FACTION'=> 243,
    'SPELL_AURA_COMPREHEND_LANGUAGE'=> 244,
    'SPELL_AURA_MOD_AURA_DURATION_BY_DISPEL'=> 245,
    'SPELL_AURA_MOD_AURA_DURATION_BY_DISPEL_NOT_STACK'=> 246,
    'SPELL_AURA_CLONE_CASTER'=> 247,
    'SPELL_AURA_MOD_COMBAT_RESULT_CHANCE'=> 248,
    'SPELL_AURA_CONVERT_RUNE'=> 249,
    'SPELL_AURA_MOD_INCREASE_HEALTH_2'=> 250,
    'SPELL_AURA_MOD_ENEMY_DODGE'=> 251,
    'SPELL_AURA_MOD_SPEED_SLOW_ALL'=> 252,
    'SPELL_AURA_MOD_BLOCK_CRIT_CHANCE'=> 253,
    'SPELL_AURA_MOD_DISARM_OFFHAND'=> 254,
    'SPELL_AURA_MOD_MECHANIC_DAMAGE_TAKEN_PERCENT'=> 255,
    'SPELL_AURA_NO_REAGENT_USE'=> 256,
    'SPELL_AURA_MOD_TARGET_RESIST_BY_SPELL_CLASS'=> 257,
    'SPELL_AURA_258'=> 258,
    'SPELL_AURA_MOD_HOT_PCT'=> 259,
    'SPELL_AURA_SCREEN_EFFECT'=> 260,
    'SPELL_AURA_PHASE'=> 261,
    'SPELL_AURA_ABILITY_IGNORE_AURASTATE'=> 262,
    'SPELL_AURA_ALLOW_ONLY_ABILITY'=> 263,
    'SPELL_AURA_264'=> 264,
    'SPELL_AURA_265'=> 265,
    'SPELL_AURA_266'=> 266,
    'SPELL_AURA_MOD_IMMUNE_AURA_APPLY_SCHOOL'=> 267,
    'SPELL_AURA_MOD_ATTACK_POWER_OF_STAT_PERCENT'=> 268,
    'SPELL_AURA_MOD_IGNORE_TARGET_RESIST'=> 269,
    'SPELL_AURA_MOD_ABILITY_IGNORE_TARGET_RESIST'=> 270,     // Possibly need swap vs 195 aura used only in 1 spell Chaos Bolt Passive
    'SPELL_AURA_MOD_DAMAGE_FROM_CASTER'=> 271,
    'SPELL_AURA_IGNORE_MELEE_RESET'=> 272,
    'SPELL_AURA_X_RAY'=> 273,
    'SPELL_AURA_ABILITY_CONSUME_NO_AMMO'=> 274,
    'SPELL_AURA_MOD_IGNORE_SHAPESHIFT'=> 275,
    'SPELL_AURA_276'=> 276,                                  // Only "Test Mod Damage % Mechanic" spell, possible mod damage done
    'SPELL_AURA_MOD_MAX_AFFECTED_TARGETS'=> 277,
    'SPELL_AURA_MOD_DISARM_RANGED'=> 278,
    'SPELL_AURA_INITIALIZE_IMAGES'=> 279,
    'SPELL_AURA_MOD_ARMOR_PENETRATION_PCT'=> 280,
    'SPELL_AURA_MOD_HONOR_GAIN_PCT'=> 281,
    'SPELL_AURA_MOD_BASE_HEALTH_PCT'=> 282,
    'SPELL_AURA_MOD_HEALING_RECEIVED'=> 283,                 // Possibly only for some spell family class spells
    'SPELL_AURA_LINKED'=> 284,
    'SPELL_AURA_MOD_ATTACK_POWER_OF_ARMOR'=> 285,
    'SPELL_AURA_ABILITY_PERIODIC_CRIT'=> 286,
    'SPELL_AURA_DEFLECT_SPELLS'=> 287,
    'SPELL_AURA_IGNORE_HIT_DIRECTION'=> 288,
    'SPELL_AURA_289'=> 289,
    'SPELL_AURA_MOD_CRIT_PCT'=> 290,
    'SPELL_AURA_MOD_XP_QUEST_PCT'=> 291,
    'SPELL_AURA_OPEN_STABLE'=> 292,
    'SPELL_AURA_OVERRIDE_SPELLS'=> 293,
    'SPELL_AURA_PREVENT_REGENERATE_POWER'=> 294,
    'SPELL_AURA_295'=> 295,
    'SPELL_AURA_SET_VEHICLE_ID'=> 296,
    'SPELL_AURA_BLOCK_SPELL_FAMILY'=> 297,
    'SPELL_AURA_STRANGULATE'=> 298,
    'SPELL_AURA_299'=> 299,
    'SPELL_AURA_SHARE_DAMAGE_PCT'=> 300,
    'SPELL_AURA_SCHOOL_HEAL_ABSORB'=> 301,
    'SPELL_AURA_302'=> 302,
    'SPELL_AURA_MOD_DAMAGE_DONE_VERSUS_AURASTATE'=> 303,
    'SPELL_AURA_MOD_FAKE_INEBRIATE'=> 304,
    'SPELL_AURA_MOD_MINIMUM_SPEED'=> 305,
    'SPELL_AURA_306'=> 306,
    'SPELL_AURA_HEAL_ABSORB_TEST'=> 307,
    'SPELL_AURA_308'=> 308,
    'SPELL_AURA_309'=> 309,
    'SPELL_AURA_MOD_CREATURE_AOE_DAMAGE_AVOIDANCE'=> 310,
    'SPELL_AURA_311'=> 311,
    'SPELL_AURA_312'=> 312,
    'SPELL_AURA_313'=> 313,
    'SPELL_AURA_PREVENT_RESSURECTION'=> 314,
    'SPELL_AURA_UNDERWATER_WALKING'=> 315,
    'SPELL_AURA_PERIODIC_HASTE'=> 316
));
$defineMap->pushToArray($enumSpellAuras);

// Spell prevention
$defineMap->createDefines(array(
    'SPELL_PREVENTION_TYPE_NONE'=>    0,
    'SPELL_PREVENTION_TYPE_SILENCE'=> 1,
    'SPELL_PREVENTION_TYPE_PACIFY'=>  2
));
$defineMap->pushToArray($enumSpellPreventionType);
 
// Spell Attr0
$defineMap->createDefines(array(
    'SPELL_ATTR0_UNK0'=> 0x00000001,//  0
    'SPELL_ATTR0_REQ_AMMO'=> 0x00000002,//  1
    'SPELL_ATTR0_ON_NEXT_SWING'=> 0x00000004,//  2 on next swing
    'SPELL_ATTR0_UNK3'=> 0x00000008,//  3 not set in 3.0.3
    'SPELL_ATTR0_UNK4'=> 0x00000010,//  4
    'SPELL_ATTR0_TRADESPELL'=> 0x00000020,//  5 trade spells, will be added by client to a sublist of profession spell
    'SPELL_ATTR0_PASSIVE'=> 0x00000040,//  6 Passive spell
    'SPELL_ATTR0_UNK7'=> 0x00000080,//  7 visible?
    'SPELL_ATTR0_UNK8'=> 0x00000100,//  8
    'SPELL_ATTR0_UNK9'=> 0x00000200,//  9
    'SPELL_ATTR0_UNK10'=> 0x00000400,// 10 on next swing 2
    'SPELL_ATTR0_UNK11'=> 0x00000800,// 11
    'SPELL_ATTR0_DAYTIME_ONLY'=> 0x00001000,// 12 only useable at daytime, not set in 2.4.2
    'SPELL_ATTR0_NIGHT_ONLY'=> 0x00002000,// 13 only useable at night, not set in 2.4.2
    'SPELL_ATTR0_INDOORS_ONLY'=> 0x00004000,// 14 only useable indoors, not set in 2.4.2
    'SPELL_ATTR0_OUTDOORS_ONLY'=> 0x00008000,// 15 Only useable outdoors.
    'SPELL_ATTR0_NOT_SHAPESHIFT'=> 0x00010000,// 16 Not while shapeshifted
    'SPELL_ATTR0_ONLY_STEALTHED'=> 0x00020000,// 17 Must be in stealth
    'SPELL_ATTR0_UNK18'=> 0x00040000,// 18
    'SPELL_ATTR0_LEVEL_DAMAGE_CALCULATION'=> 0x00080000,// 19 spelldamage depends on caster level
    'SPELL_ATTR0_STOP_ATTACK_TARGET'=> 0x00100000,// 20 Stop attack after use this spell (and not begin attack if use)
    'SPELL_ATTR0_IMPOSSIBLE_DODGE_PARRY_BLOCK'=> 0x00200000,// 21 Cannot be dodged/parried/blocked
    'SPELL_ATTR0_UNK22'=> 0x00400000,// 22 shoot spells
    'SPELL_ATTR0_CASTABLE_WHILE_DEAD'=> 0x00800000,// 23 castable while dead?
    'SPELL_ATTR0_CASTABLE_WHILE_MOUNTED'=> 0x01000000,// 24 castable while mounted
    'SPELL_ATTR0_DISABLED_WHILE_ACTIVE'=> 0x02000000,// 25 Activate and start cooldown after aura fade or remove summoned creature or go
    'SPELL_ATTR0_NEGATIVE_1'=> 0x04000000,// 26 Many negative spells have this attr
    'SPELL_ATTR0_CASTABLE_WHILE_SITTING'=> 0x08000000,// 27 castable while sitting
    'SPELL_ATTR0_CANT_USED_IN_COMBAT'=> 0x10000000,// 28 Cannot be used in combat
    'SPELL_ATTR0_UNAFFECTED_BY_INVULNERABILITY'=> 0x20000000,// 29 unaffected by invulnerability (hmm possible not...)
    'SPELL_ATTR0_BREAKABLE_BY_DAMAGE'=> 0x40000000,// 30
    'SPELL_ATTR0_CANT_CANCEL'=> 0x80000000, // 31 positive aura can't be canceled
));
$defineMap->pushToArray($enumSpellAttr0);

$defineMap->createDefines(array(
    'SPELL_ATTR1_DISMISS_PET'=> 0x00000001,//  0 dismiss pet and not allow to summon new one?
    'SPELL_ATTR1_DRAIN_ALL_POWER'=> 0x00000002,//  1 use all power (Only paladin Lay of Hands and Bunyanize)
    'SPELL_ATTR1_CHANNELED_1'=> 0x00000004,//  2 channeled target
    'SPELL_ATTR1_PUT_CASTER_IN_COMBAT'=> 0x00000008,// 3 spells that cause a caster to enter a combat
    'SPELL_ATTR1_UNK4'=> 0x00000010,// 4 stealth and whirlwind
    'SPELL_ATTR1_NOT_BREAK_STEALTH'=> 0x00000020,//  5 Not break stealth
    'SPELL_ATTR1_CHANNELED_2'=> 0x00000040,//  6 channeled self
    'SPELL_ATTR1_NEGATIVE'=> 0x00000080,//  7
    'SPELL_ATTR1_NOT_IN_COMBAT_TARGET'=> 0x00000100,//  8 Spell req target not to be in combat state
    'SPELL_ATTR1_UNK9'=> 0x00000200,//  9 melee spells
    'SPELL_ATTR1_NO_THREAT'=> 0x00000400,// 10 no generates threat on cast 100% (old NO_INITIAL_AGGRO)
    'SPELL_ATTR1_UNK11'=> 0x00000800,// 11 aura
    'SPELL_ATTR1_UNK12'=> 0x00001000,// 12
    'SPELL_ATTR1_USE_RADIUS_AS_MAX_DISTANCE'=> 0x00002000,// 13
    'SPELL_ATTR1_STACK_FOR_DIFF_CASTERS'=> 0x00004000,// 14
    'SPELL_ATTR1_DISPEL_AURAS_ON_IMMUNITY'=> 0x00008000,// 15 remove auras on immunity
    'SPELL_ATTR1_UNAFFECTED_BY_SCHOOL_IMMUNE'=> 0x00010000,// 16 on immuniy
    'SPELL_ATTR1_UNAUTOCASTABLE_BY_PET'=> 0x00020000,// 17
    'SPELL_ATTR1_UNK18'=> 0x00040000,// 18
    'SPELL_ATTR1_CANT_TARGET_SELF'=> 0x00080000,// 19 Applies only to unit target - for example Divine Intervention (19752)
    'SPELL_ATTR1_REQ_COMBO_POINTS1'=> 0x00100000,// 20 Req combo points on target
    'SPELL_ATTR1_UNK21'=> 0x00200000,// 21
    'SPELL_ATTR1_REQ_COMBO_POINTS2'=> 0x00400000,// 22 Req combo points on target
    'SPELL_ATTR1_UNK23'=> 0x00800000,// 23
    'SPELL_ATTR1_UNK24'=> 0x01000000,// 24 Req fishing pole??
    'SPELL_ATTR1_UNK25'=> 0x02000000,// 25
    'SPELL_ATTR1_UNK26'=> 0x04000000,// 26 works correctly with [target=focus] and [target=mouseover] macros?
    'SPELL_ATTR1_UNK27'=> 0x08000000,// 27
    'SPELL_ATTR1_IGNORE_IMMUNITY'=> 0x10000000,// 28 removed from Chains of Ice 3.3.0
    'SPELL_ATTR1_UNK29'=> 0x20000000,// 29
    'SPELL_ATTR1_ENABLE_AT_DODGE'=> 0x40000000,// 30 Overpower, Wolverine Bite
    'SPELL_ATTR1_UNK31'=> 0x80000000,// 31
));
$defineMap->pushToArray($enumSpellAttr1);

// Spell Attr2
$defineMap->createDefines(array(
    'SPELL_ATTR2_ALLOW_DEAD_TARGET'=> 0x00000001, //  0
    'SPELL_ATTR2_UNK1'=> 0x00000002, //  1 ? many triggered spells have this flag
    'SPELL_ATTR2_CANT_REFLECTED'=> 0x00000004, //  2 ? used for detect can or not spell reflected
    'SPELL_ATTR2_UNK3'=> 0x00000008, //  3
    'SPELL_ATTR2_ALWAYS_APPLY_MODIFIERS'=> 0x00000010, //  4 ? spell modifiers are applied dynamically (even if aura is not passive)
    'SPELL_ATTR2_AUTOREPEAT_FLAG'=> 0x00000020, //  5
    'SPELL_ATTR2_UNK6'=> 0x00000040, //  6
    'SPELL_ATTR2_UNK7'=> 0x00000080, //  7
    'SPELL_ATTR2_UNK8'=> 0x00000100, //  8 not set in 3.0.3
    'SPELL_ATTR2_UNK9'=> 0x00000200, //  9
    'SPELL_ATTR2_UNK10'=> 0x00000400, // 10
    'SPELL_ATTR2_HEALTH_FUNNEL'=> 0x00000800, // 11
    'SPELL_ATTR2_UNK12'=> 0x00001000, // 12
    'SPELL_ATTR2_UNK13'=> 0x00002000, // 13 Items enchanted by spells with this flag preserve the enchant to arenas
    'SPELL_ATTR2_UNK14'=> 0x00004000, // 14
    'SPELL_ATTR2_UNK15'=> 0x00008000, // 15 not set in 3.0.3
    'SPELL_ATTR2_TAME_BEAST'=> 0x00010000, // 16
    'SPELL_ATTR2_NOT_RESET_AUTO_ACTIONS'=> 0x00020000, // 17 don't reset timers for melee autoattacks (swings) or ranged autoattacks (autoshoots)
    'SPELL_ATTR2_UNK18'=> 0x00040000, // 18 Only Revive pet - possible req dead pet
    'SPELL_ATTR2_NOT_NEED_SHAPESHIFT'=> 0x00080000, // 19 does not necessarly need shapeshift
    'SPELL_ATTR2_UNK20'=> 0x00100000, // 20
    'SPELL_ATTR2_DAMAGE_REDUCED_SHIELD'=> 0x00200000, // 21 for ice blocks, pala immunity buffs, priest absorb shields, but used also for other spells -> not sure!
    'SPELL_ATTR2_UNK22'=> 0x00400000, // 22
    'SPELL_ATTR2_UNK23'=> 0x00800000, // 23 Only mage Arcane Concentration have this flag
    'SPELL_ATTR2_UNK24'=> 0x01000000, // 24
    'SPELL_ATTR2_UNK25'=> 0x02000000, // 25
    'SPELL_ATTR2_UNK26'=> 0x04000000, // 26 unaffected by school immunity
    'SPELL_ATTR2_UNK27'=> 0x08000000, // 27
    'SPELL_ATTR2_UNK28'=> 0x10000000, // 28 no breaks stealth if it fails??
    'SPELL_ATTR2_CANT_CRIT'=> 0x20000000, // 29 Spell can't crit
    'SPELL_ATTR2_TRIGGERED_CAN_TRIGGER'=> 0x40000000, // 30 spell can trigger even if triggered
    'SPELL_ATTR2_FOOD_BUFF'=> 0x80000000, // 31 Food or Drink Buff (like Well Fed)
));
$defineMap->pushToArray($enumSpellAttr2);

$defineMap->createDefines(array(
    'SPELL_ATTR3_UNK0'=>                             0x00000001, //  0
    'SPELL_ATTR3_UNK1'=>                             0x00000002, //  1
    'SPELL_ATTR3_UNK2'=>                             0x00000004, //  2
    'SPELL_ATTR3_BLOCKABLE_SPELL'=>                  0x00000008, //  3 Only dmg class melee in 3.1.3
    'SPELL_ATTR3_UNK4'=>                             0x00000010, //  4 Druid Rebirth only this spell have this flag
    'SPELL_ATTR3_UNK5'=>                             0x00000020, //  5
    'SPELL_ATTR3_UNK6'=>                             0x00000040, //  6
    'SPELL_ATTR3_STACK_FOR_DIFF_CASTERS'=>           0x00000080, //  7 separate stack for every caster
    'SPELL_ATTR3_PLAYERS_ONLY'=>                     0x00000100, //  8 Player only?
    'SPELL_ATTR3_TRIGGERED_CAN_TRIGGER_2'=>          0x00000200, //  9 triggered from effect?
    'SPELL_ATTR3_MAIN_HAND'=>                        0x00000400, // 10 Main hand weapon required
    'SPELL_ATTR3_BATTLEGROUND'=>                     0x00000800, // 11 Can casted only on battleground
    'SPELL_ATTR3_REQUIRE_DEAD_TARGET'=>              0x00001000, // 12
    'SPELL_ATTR3_UNK13'=>                            0x00002000, // 13
    'SPELL_ATTR3_UNK14'=>                            0x00004000, // 14 "Honorless Target" only this spells have this flag
    'SPELL_ATTR3_UNK15'=>                            0x00008000, // 15 Auto Shoot, Shoot, Throw,  - this is autoshot flag
    'SPELL_ATTR3_UNK16'=>                            0x00010000, // 16 no triggers effects that trigger on casting a spell?? (15290 - 2.2ptr change)
    'SPELL_ATTR3_NO_INITIAL_AGGRO'=>                 0x00020000, // 17 Soothe Animal, 39758, Mind Soothe
    'SPELL_ATTR3_UNK18'=>                            0x00040000, // 18 added to Explosive Trap Effect 3.3.0, removed from Mutilate 3.3.0
    'SPELL_ATTR3_DISABLE_PROC'=>                     0x00080000, // 19 during aura proc no spells can trigger (20178, 20375)
    'SPELL_ATTR3_DEATH_PERSISTENT'=>                 0x00100000, // 20 Death persistent spells
    'SPELL_ATTR3_UNK21'=>                            0x00200000, // 21
    'SPELL_ATTR3_REQ_WAND'=>                         0x00400000, // 22 Req wand
    'SPELL_ATTR3_UNK23'=>                            0x00800000, // 23
    'SPELL_ATTR3_REQ_OFFHAND'=>                      0x01000000, // 24 Req offhand weapon
    'SPELL_ATTR3_UNK25'=>                            0x02000000, // 25 no cause spell pushback ?
    'SPELL_ATTR3_CAN_PROC_TRIGGERED'=>               0x04000000, // 26
    'SPELL_ATTR3_DRAIN_SOUL'=>                       0x08000000, // 27 only drain soul has this flag
    'SPELL_ATTR3_UNK28'=>                            0x10000000, // 28
    'SPELL_ATTR3_NO_DONE_BONUS'=>                    0x20000000, // 29 Ignore caster spellpower and done damage mods?
    'SPELL_ATTR3_UNK30'=>                            0x40000000, // 30 Shaman's Fire Nova 3.3.0, Sweeping Strikes 3.3.0
    'SPELL_ATTR3_UNK31'=>                            0x80000000, // 31
));
$defineMap->pushToArray($enumSpellAttr3);

$defineMap->createDefines(array(
    'SPELL_ATTR4_UNK0'=>                             0x00000001, //  0
    'SPELL_ATTR4_UNK1'=>                             0x00000002, //  1 proc on finishing move?
    'SPELL_ATTR4_UNK2'=>                             0x00000004, //  2
    'SPELL_ATTR4_CANT_PROC_FROM_SELFCAST'=>          0x00000008, //  3
    'SPELL_ATTR4_UNK4'=>                             0x00000010, //  4 This will no longer cause guards to attack on use??
    'SPELL_ATTR4_UNK5'=>                             0x00000020, //  5
    'SPELL_ATTR4_NOT_STEALABLE'=>                    0x00000040, //  6 although such auras might be dispellable, they cannot be stolen
    'SPELL_ATTR4_TRIGGERED'=>                        0x00000080, //  7 spells forced to be triggered
    'SPELL_ATTR4_FIXED_DAMAGE'=>                     0x00000100, //  8 decimate, share damage?
    'SPELL_ATTR4_UNK9'=>                             0x00000200, //  9
    'SPELL_ATTR4_SPELL_VS_EXTEND_COST'=>             0x00000400, // 10 Rogue Shiv have this flag
    'SPELL_ATTR4_UNK11'=>                            0x00000800, // 11
    'SPELL_ATTR4_UNK12'=>                            0x00001000, // 12
    'SPELL_ATTR4_UNK13'=>                            0x00002000, // 13
    'SPELL_ATTR4_UNK14'=>                            0x00004000, // 14
    'SPELL_ATTR4_UNK15'=>                            0x00008000, // 15
    'SPELL_ATTR4_NOT_USABLE_IN_ARENA'=>              0x00010000, // 16 not usable in arena
    'SPELL_ATTR4_USABLE_IN_ARENA'=>                  0x00020000, // 17 usable in arena
    'SPELL_ATTR4_UNK18'=>                            0x00040000, // 18
    'SPELL_ATTR4_UNK19'=>                            0x00080000, // 19
    'SPELL_ATTR4_NOT_CHECK_SELFCAST_POWER'=>         0x00100000, // 20 supersedes message "More powerful spell applied" for self casts.
    'SPELL_ATTR4_UNK21'=>                            0x00200000, // 21
    'SPELL_ATTR4_UNK22'=>                            0x00400000, // 22
    'SPELL_ATTR4_UNK23'=>                            0x00800000, // 23
    'SPELL_ATTR4_UNK24'=>                            0x01000000, // 24
    'SPELL_ATTR4_UNK25'=>                            0x02000000, // 25 pet scaling auras
    'SPELL_ATTR4_CAST_ONLY_IN_OUTLAND'=>             0x04000000, // 26 Can only be used in Outland.
    'SPELL_ATTR4_UNK27'=>                            0x08000000, // 27
    'SPELL_ATTR4_UNK28'=>                            0x10000000, // 28
    'SPELL_ATTR4_UNK29'=>                            0x20000000, // 29
    'SPELL_ATTR4_UNK30'=>                            0x40000000, // 30
    'SPELL_ATTR4_UNK31'=>                            0x80000000, // 31
));
$defineMap->pushToArray($enumSpellAttr4);

$defineMap->createDefines(array(
    'SPELL_ATTR5_UNK0'=>                             0x00000001, //  0
    'SPELL_ATTR5_NO_REAGENT_WHILE_PREP'=>            0x00000002, //  1 not need reagents if UNIT_FLAG_PREPARATION
    'SPELL_ATTR5_UNK2'=>                             0x00000004, //  2
    'SPELL_ATTR5_USABLE_WHILE_STUNNED'=>             0x00000008, //  3 usable while stunned
    'SPELL_ATTR5_UNK4'=>                             0x00000010, //  4
    'SPELL_ATTR5_SINGLE_TARGET_SPELL'=>              0x00000020, //  5 Only one target can be apply at a time
    'SPELL_ATTR5_UNK6'=>                             0x00000040, //  6
    'SPELL_ATTR5_UNK7'=>                             0x00000080, //  7
    'SPELL_ATTR5_UNK8'=>                             0x00000100, //  8
    'SPELL_ATTR5_START_PERIODIC_AT_APPLY'=>          0x00000200, //  9  begin periodic tick at aura apply
    'SPELL_ATTR5_UNK10'=>                            0x00000400, // 10
    'SPELL_ATTR5_UNK11'=>                            0x00000800, // 11
    'SPELL_ATTR5_UNK12'=>                            0x00001000, // 12
    'SPELL_ATTR5_UNK13'=>                            0x00002000, // 13
    'SPELL_ATTR5_UNK14'=>                            0x00004000, // 14
    'SPELL_ATTR5_UNK15'=>                            0x00008000, // 15
    'SPELL_ATTR5_SPECIAL_ITEM_CLASS_CHECK'=>         0x00010000, // 16 this allows spells with EquippedItemClass to affect spells from other items if the required item is equipped
    'SPELL_ATTR5_USABLE_WHILE_FEARED'=>              0x00020000, // 17 usable while feared
    'SPELL_ATTR5_USABLE_WHILE_CONFUSED'=>            0x00040000, // 18 usable while confused
    'SPELL_ATTR5_UNK19'=>                            0x00080000, // 19
    'SPELL_ATTR5_UNK20'=>                            0x00100000, // 20
    'SPELL_ATTR5_UNK21'=>                            0x00200000, // 21
    'SPELL_ATTR5_UNK22'=>                            0x00400000, // 22
    'SPELL_ATTR5_UNK23'=>                            0x00800000, // 23
    'SPELL_ATTR5_UNK24'=>                            0x01000000, // 24
    'SPELL_ATTR5_UNK25'=>                            0x02000000, // 25
    'SPELL_ATTR5_UNK26'=>                            0x04000000, // 26
    'SPELL_ATTR5_UNK27'=>                            0x08000000, // 27
    'SPELL_ATTR5_UNK28'=>                            0x10000000, // 28
    'SPELL_ATTR5_UNK29'=>                            0x20000000, // 29
    'SPELL_ATTR5_UNK30'=>                            0x40000000, // 30
    'SPELL_ATTR5_UNK31'=>                            0x80000000, // 31 Forces all nearby enemies to focus attacks caster
));
$defineMap->pushToArray($enumSpellAttr5);

$defineMap->createDefines(array(
    'SPELL_ATTR6_UNK0'=>                             0x00000001, //  0 Only Move spell have this flag
    'SPELL_ATTR6_ONLY_IN_ARENA'=>                    0x00000002, //  1 only usable in arena
    'SPELL_ATTR6_IGNORE_CASTER_AURAS'=>              0x00000004, //  2
    'SPELL_ATTR6_UNK3'=>                             0x00000008, //  3
    'SPELL_ATTR6_UNK4'=>                             0x00000010, //  4
    'SPELL_ATTR6_UNK5'=>                             0x00000020, //  5
    'SPELL_ATTR6_UNK6'=>                             0x00000040, //  6
    'SPELL_ATTR6_UNK7'=>                             0x00000080, //  7
    'SPELL_ATTR6_IGNORE_CROWD_CONTROL_TARGETS'=>     0x00000100, //  8
    'SPELL_ATTR6_UNK9'=>                             0x00000200, //  9
    'SPELL_ATTR6_UNK10'=>                            0x00000400, // 10
    'SPELL_ATTR6_NOT_IN_RAID_INSTANCE'=>             0x00000800, // 11 not usable in raid instance
    'SPELL_ATTR6_UNK12'=>                            0x00001000, // 12
    'SPELL_ATTR6_UNK13'=>                            0x00002000, // 13
    'SPELL_ATTR6_UNK14'=>                            0x00004000, // 14
    'SPELL_ATTR6_UNK15'=>                            0x00008000, // 15 not set in 3.0.3
    'SPELL_ATTR6_UNK16'=>                            0x00010000, // 16
    'SPELL_ATTR6_UNK17'=>                            0x00020000, // 17
    'SPELL_ATTR6_UNK18'=>                            0x00040000, // 18
    'SPELL_ATTR6_UNK19'=>                            0x00080000, // 19
    'SPELL_ATTR6_UNK20'=>                            0x00100000, // 20
    'SPELL_ATTR6_CLIENT_UI_TARGET_EFFECTS'=>         0x00200000, // 21 it's only client-side attribute
    'SPELL_ATTR6_UNK22'=>                            0x00400000, // 22
    'SPELL_ATTR6_UNK23'=>                            0x00800000, // 23 not set in 3.0.3
    'SPELL_ATTR6_UNK24'=>                            0x01000000, // 24 not set in 3.0.3
    'SPELL_ATTR6_UNK25'=>                            0x02000000, // 25 not set in 3.0.3
    'SPELL_ATTR6_UNK26'=>                            0x04000000, // 26 not set in 3.0.3
    'SPELL_ATTR6_UNK27'=>                            0x08000000, // 27 not set in 3.0.3
    'SPELL_ATTR6_UNK28'=>                            0x10000000, // 28 not set in 3.0.3
    'SPELL_ATTR6_UNK29'=>                            0x20000000, // 29 not set in 3.0.3
    'SPELL_ATTR6_UNK30'=>                            0x40000000, // 30 not set in 3.0.3
    'SPELL_ATTR6_UNK31'=>                            0x80000000, // 31 not set in 3.0.3
));
$defineMap->pushToArray($enumSpellAttr6);

$defineMap->createDefines(array(
    'SPELL_ATTR7_UNK0'=>                             0x00000001,  //  0 Shaman's new spells (Call of the ...,Feign Death.
    'SPELL_ATTR7_UNK1'=>                             0x00000002, //  1 Not set in 3.2.2a.
    'SPELL_ATTR7_REACTIVATE_AT_RESURRECT'=>          0x00000004, //  2 Paladin's auras and 65607 only.
    'SPELL_ATTR7_DISABLED_CLIENT_SIDE'=>             0x00000008, //  3 used only by client to disable spells client-side. some sort of special player flag (0x40000) bypasses that restriction
    'SPELL_ATTR7_UNK4'=>                             0x00000010, //  4 Only 66109 test spell.
    'SPELL_ATTR7_SUMMON_PLAYER_TOTEM'=>              0x00000020, //  5 Only Shaman player totems.
    'SPELL_ATTR7_UNK6'=>                             0x00000040, //  6 Dark Surge, Surge of Light, Burning Breath triggers (boss spells).
    'SPELL_ATTR7_UNK7'=>                             0x00000080, //  7 66218 (Launch) spell.
    'SPELL_ATTR7_UNK8'=>                             0x00000100, //  8 Teleports, mounts and other spells.
    'SPELL_ATTR7_UNK9'=>                             0x00000200, //  9 Teleports, mounts and other spells.
    'SPELL_ATTR7_DISPEL_CHARGES'=>                   0x00000400, // 10 Dispel and Spellsteal individual charges instead of whole aura.
    'SPELL_ATTR7_INTERRUPT_ONLY_NONPLAYER'=>         0x00000800, // 11 Only non-player casts interrupt, though Feral Charge - Bear has it.
    'SPELL_ATTR7_UNK12'=>                            0x00001000, // 12 Not set in 3.2.2a.
    'SPELL_ATTR7_UNK13'=>                            0x00002000, // 13 Not set in 3.2.2a.
    'SPELL_ATTR7_UNK14'=>                            0x00004000, // 14 Only 52150 (Raise Dead - Pet) spell.
    'SPELL_ATTR7_UNK15'=>                            0x00008000, // 15 Exorcism. Usable on players? 100% crit chance on undead and demons?
    'SPELL_ATTR7_UNK16'=>                            0x00010000, // 16 Druid spells (29166, 54833, 64372, 68285).
    'SPELL_ATTR7_UNK17'=>                            0x00020000, // 17 Only 27965 (Suicide) spell.
    'SPELL_ATTR7_HAS_CHARGE_EFFECT'=>                0x00040000, // 18 Only spells that have Charge among effects.
    'SPELL_ATTR7_ZONE_TELEPORT'=>                    0x00080000, // 19 Teleports to specific zones.
));
$defineMap->pushToArray($enumSpellAttr7);

$defineMap->createDefines(array(
    'DISPEL_NONE'=>         0,
    'DISPEL_MAGIC'=>        1,
    'DISPEL_CURSE'=>        2,
    'DISPEL_DISEASE'=>      3,
    'DISPEL_POISON'=>       4,
    'DISPEL_STEALTH'=>      5,
    'DISPEL_INVISIBILITY'=> 6,
    'DISPEL_ALL'=>          7,
    'DISPEL_SPE_NPC_ONLY'=> 8,
    'DISPEL_ENRAGE'=>       9,
    'DISPEL_ZG_TICKET'=>    10,
    'DESPEL_OLD_UNUSED'=>   11,
));
$defineMap->pushToArray($enumDispelTypes);

$defineMap->createDefines(array(
    'SPELL_EFFECT_INSTAKILL'=>                 1,
    'SPELL_EFFECT_SCHOOL_DAMAGE'=>             2,
    'SPELL_EFFECT_DUMMY'=>                     3,
    'SPELL_EFFECT_PORTAL_TELEPORT'=>           4,
    'SPELL_EFFECT_TELEPORT_UNITS'=>            5,
    'SPELL_EFFECT_APPLY_AURA'=>                6,
    'SPELL_EFFECT_ENVIRONMENTAL_DAMAGE'=>      7,
    'SPELL_EFFECT_POWER_DRAIN'=>               8,
    'SPELL_EFFECT_HEALTH_LEECH'=>              9,
    'SPELL_EFFECT_HEAL'=>                      10,
    'SPELL_EFFECT_BIND'=>                      11,
    'SPELL_EFFECT_PORTAL'=>                    12,
    'SPELL_EFFECT_RITUAL_BASE'=>               13,
    'SPELL_EFFECT_RITUAL_SPECIALIZE'=>         14,
    'SPELL_EFFECT_RITUAL_ACTIVATE_PORTAL'=>    15,
    'SPELL_EFFECT_QUEST_COMPLETE'=>            16,
    'SPELL_EFFECT_WEAPON_DAMAGE_NOSCHOOL'=>    17,
    'SPELL_EFFECT_RESURRECT'=>                 18,
    'SPELL_EFFECT_ADD_EXTRA_ATTACKS'=>         19,
    'SPELL_EFFECT_DODGE'=>                     20,
    'SPELL_EFFECT_EVADE'=>                     21,
    'SPELL_EFFECT_PARRY'=>                     22,
    'SPELL_EFFECT_BLOCK'=>                     23,
    'SPELL_EFFECT_CREATE_ITEM'=>               24,
    'SPELL_EFFECT_WEAPON'=>                    25,
    'SPELL_EFFECT_DEFENSE'=>                   26,
    'SPELL_EFFECT_PERSISTENT_AREA_AURA'=>      27,
    'SPELL_EFFECT_SUMMON'=>                    28,
    'SPELL_EFFECT_LEAP'=>                      29,
    'SPELL_EFFECT_ENERGIZE'=>                  30,
    'SPELL_EFFECT_WEAPON_PERCENT_DAMAGE'=>     31,
    'SPELL_EFFECT_TRIGGER_MISSILE'=>           32,
    'SPELL_EFFECT_OPEN_LOCK'=>                 33,
    'SPELL_EFFECT_SUMMON_CHANGE_ITEM'=>        34,
    'SPELL_EFFECT_APPLY_AREA_AURA_PARTY'=>     35,
    'SPELL_EFFECT_LEARN_SPELL'=>               36,
    'SPELL_EFFECT_SPELL_DEFENSE'=>             37,
    'SPELL_EFFECT_DISPEL'=>                    38,
    'SPELL_EFFECT_LANGUAGE'=>                  39,
    'SPELL_EFFECT_DUAL_WIELD'=>                40,
    'SPELL_EFFECT_JUMP'=>                      41,
    'SPELL_EFFECT_JUMP_DEST'=>                 42,
    'SPELL_EFFECT_TELEPORT_UNITS_FACE_CASTER'=>43,
    'SPELL_EFFECT_SKILL_STEP'=>                44,
    'SPELL_EFFECT_ADD_HONOR'=>                 45,
    'SPELL_EFFECT_SPAWN'=>                     46,
    'SPELL_EFFECT_TRADE_SKILL'=>               47,
    'SPELL_EFFECT_STEALTH'=>                   48,
    'SPELL_EFFECT_DETECT'=>                    49,
    'SPELL_EFFECT_TRANS_DOOR'=>                50,
    'SPELL_EFFECT_FORCE_CRITICAL_HIT'=>        51,
    'SPELL_EFFECT_GUARANTEE_HIT'=>             52,
    'SPELL_EFFECT_ENCHANT_ITEM'=>              53,
    'SPELL_EFFECT_ENCHANT_ITEM_TEMPORARY'=>    54,
    'SPELL_EFFECT_TAMECREATURE'=>              55,
    'SPELL_EFFECT_SUMMON_PET'=>                56,
    'SPELL_EFFECT_LEARN_PET_SPELL'=>           57,
    'SPELL_EFFECT_WEAPON_DAMAGE'=>             58,
    'SPELL_EFFECT_CREATE_RANDOM_ITEM'=>        59,
    'SPELL_EFFECT_PROFICIENCY'=>               60,
    'SPELL_EFFECT_SEND_EVENT'=>                61,
    'SPELL_EFFECT_POWER_BURN'=>                62,
    'SPELL_EFFECT_THREAT'=>                    63,
    'SPELL_EFFECT_TRIGGER_SPELL'=>             64,
    'SPELL_EFFECT_APPLY_AREA_AURA_RAID'=>      65,
    'SPELL_EFFECT_CREATE_MANA_GEM'=>           66,
    'SPELL_EFFECT_HEAL_MAX_HEALTH'=>           67,
    'SPELL_EFFECT_INTERRUPT_CAST'=>            68,
    'SPELL_EFFECT_DISTRACT'=>                  69,
    'SPELL_EFFECT_PULL'=>                      70,
    'SPELL_EFFECT_PICKPOCKET'=>                71,
    'SPELL_EFFECT_ADD_FARSIGHT'=>              72,
    'SPELL_EFFECT_UNTRAIN_TALENTS'=>           73,
    'SPELL_EFFECT_APPLY_GLYPH'=>               74,
    'SPELL_EFFECT_HEAL_MECHANICAL'=>           75,
    'SPELL_EFFECT_SUMMON_OBJECT_WILD'=>        76,
    'SPELL_EFFECT_SCRIPT_EFFECT'=>             77,
    'SPELL_EFFECT_ATTACK'=>                    78,
    'SPELL_EFFECT_SANCTUARY'=>                 79,
    'SPELL_EFFECT_ADD_COMBO_POINTS'=>          80,
    'SPELL_EFFECT_CREATE_HOUSE'=>              81,
    'SPELL_EFFECT_BIND_SIGHT'=>                82,
    'SPELL_EFFECT_DUEL'=>                      83,
    'SPELL_EFFECT_STUCK'=>                     84,
    'SPELL_EFFECT_SUMMON_PLAYER'=>             85,
    'SPELL_EFFECT_ACTIVATE_OBJECT'=>           86,
    'SPELL_EFFECT_WMO_DAMAGE'=>                87,
    'SPELL_EFFECT_WMO_REPAIR'=>                88,
    'SPELL_EFFECT_WMO_CHANGE'=>                89,
    'SPELL_EFFECT_KILL_CREDIT'=>               90,
    'SPELL_EFFECT_THREAT_ALL'=>                91,
    'SPELL_EFFECT_ENCHANT_HELD_ITEM'=>         92,
    'SPELL_EFFECT_FORCE_DESELECT'=>            93,
    'SPELL_EFFECT_SELF_RESURRECT'=>            94,
    'SPELL_EFFECT_SKINNING'=>                  95,
    'SPELL_EFFECT_CHARGE'=>                    96,
    'SPELL_EFFECT_CAST_BUTTON'=>               97,
    'SPELL_EFFECT_KNOCK_BACK'=>                98,
    'SPELL_EFFECT_DISENCHANT'=>                99,
    'SPELL_EFFECT_INEBRIATE'=>                 100,
    'SPELL_EFFECT_FEED_PET'=>                  101,
    'SPELL_EFFECT_DISMISS_PET'=>               102,
    'SPELL_EFFECT_REPUTATION'=>                103,
    'SPELL_EFFECT_SUMMON_OBJECT_SLOT1'=>       104,
    'SPELL_EFFECT_SUMMON_OBJECT_SLOT2'=>       105,
    'SPELL_EFFECT_SUMMON_OBJECT_SLOT3'=>       106,
    'SPELL_EFFECT_SUMMON_OBJECT_SLOT4'=>       107,
    'SPELL_EFFECT_DISPEL_MECHANIC'=>           108,
    'SPELL_EFFECT_SUMMON_DEAD_PET'=>           109,
    'SPELL_EFFECT_DESTROY_ALL_TOTEMS'=>        110,
    'SPELL_EFFECT_DURABILITY_DAMAGE'=>         111,
    'SPELL_EFFECT_112'=>                       112,
    'SPELL_EFFECT_RESURRECT_NEW'=>             113,
    'SPELL_EFFECT_ATTACK_ME'=>                 114,
    'SPELL_EFFECT_DURABILITY_DAMAGE_PCT'=>     115,
    'SPELL_EFFECT_SKIN_PLAYER_CORPSE'=>        116,
    'SPELL_EFFECT_SPIRIT_HEAL'=>               117,
    'SPELL_EFFECT_SKILL'=>                     118,
    'SPELL_EFFECT_APPLY_AREA_AURA_PET'=>       119,
    'SPELL_EFFECT_TELEPORT_GRAVEYARD'=>        120,
    'SPELL_EFFECT_NORMALIZED_WEAPON_DMG'=>     121,
    'SPELL_EFFECT_122'=>                       122,
    'SPELL_EFFECT_SEND_TAXI'=>                 123,
    'SPELL_EFFECT_PULL_TOWARDS'=>              124,
    'SPELL_EFFECT_MODIFY_THREAT_PERCENT'=>     125,
    'SPELL_EFFECT_STEAL_BENEFICIAL_BUFF'=>     126,
    'SPELL_EFFECT_PROSPECTING'=>               127,
    'SPELL_EFFECT_APPLY_AREA_AURA_FRIEND'=>    128,
    'SPELL_EFFECT_APPLY_AREA_AURA_ENEMY'=>     129,
    'SPELL_EFFECT_REDIRECT_THREAT'=>           130,
    'SPELL_EFFECT_131'=>                       131,
    'SPELL_EFFECT_PLAY_MUSIC'=>                132,
    'SPELL_EFFECT_UNLEARN_SPECIALIZATION'=>    133,
    'SPELL_EFFECT_KILL_CREDIT2'=>              134,
    'SPELL_EFFECT_CALL_PET'=>                  135,
    'SPELL_EFFECT_HEAL_PCT'=>                  136,
    'SPELL_EFFECT_ENERGIZE_PCT'=>              137,
    'SPELL_EFFECT_LEAP_BACK'=>                 138,
    'SPELL_EFFECT_CLEAR_QUEST'=>               139,
    'SPELL_EFFECT_FORCE_CAST'=>                140,
    'SPELL_EFFECT_FORCE_CAST_WITH_VALUE'=>     141,
    'SPELL_EFFECT_TRIGGER_SPELL_WITH_VALUE'=>  142,
    'SPELL_EFFECT_APPLY_AREA_AURA_OWNER'=>     143,
    'SPELL_EFFECT_KNOCK_BACK_DEST'=>           144,
    'SPELL_EFFECT_PULL_TOWARDS_DEST'=>         145,
    'SPELL_EFFECT_ACTIVATE_RUNE'=>             146,
    'SPELL_EFFECT_QUEST_FAIL'=>                147,
    'SPELL_EFFECT_148'=>                       148,
    'SPELL_EFFECT_CHARGE_DEST'=>               149,
    'SPELL_EFFECT_QUEST_START'=>               150,
    'SPELL_EFFECT_TRIGGER_SPELL_2'=>           151,
    'SPELL_EFFECT_152'=>                       152,
    'SPELL_EFFECT_CREATE_TAMED_PET'=>          153,
    'SPELL_EFFECT_DISCOVER_TAXI'=>             154,
    'SPELL_EFFECT_TITAN_GRIP'=>                155,
    'SPELL_EFFECT_ENCHANT_ITEM_PRISMATIC'=>    156,
    'SPELL_EFFECT_CREATE_ITEM_2'=>             157,
    'SPELL_EFFECT_MILLING'=>                   158,
    'SPELL_EFFECT_ALLOW_RENAME_PET'=>          159,
    'SPELL_EFFECT_160'=>                       160,
    'SPELL_EFFECT_TALENT_SPEC_COUNT'=>         161,
    'SPELL_EFFECT_TALENT_SPEC_SELECT'=>        162,
    'SPELL_EFFECT_163'=>                       163,
    'SPELL_EFFECT_REMOVE_AURA'=>               164,
));
$defineMap->pushToArray($enumSpellEffect);

$defineMap->createDefines(array(
    'POWER_MANA'=>          0,
    'POWER_RAGE'=>          1,
    'POWER_FOCUS'=>         2,
    'POWER_ENERGY'=>        3,
    'POWER_HAPPINESS'=>     4,
    'POWER_RUNE'=>          5,
    'POWER_RUNIC_POWER'=>   6,
    'POWER_HEALTH'=> 0xFFFFFFFE,
));
$defineMap->pushToArray($enumPowerType);

$defineMap->createDefines(array(
    'CR_WEAPON_SKILL'=>                  0x00,
    'CR_DEFENSE_SKILL'=>            1 << 0x00,
    'CR_DODGE'=>                    1 << 0x01,
    'CR_PARRY'=>                    1 << 0x02,
    'CR_BLOCK'=>                    1 << 0x03,
    'CR_HIT_MELEE'=>                1 << 0x04,
    'CR_HIT_RANGED'=>               1 << 0x05,
    'CR_HIT_SPELL'=>                1 << 0x06,
    'CR_CRIT_MELEE'=>               1 << 0x07,
    'CR_CRIT_RANGED'=>              1 << 0x08,
    'CR_CRIT_SPELL'=>               1 << 0x09,
    'CR_HIT_TAKEN_MELEE'=>          1 << 0x0A,
    'CR_HIT_TAKEN_RANGED'=>         1 << 0x0B,
    'CR_HIT_TAKEN_SPELL'=>          1 << 0x0C,
    'CR_CRIT_TAKEN_MELEE'=>         1 << 0x0D,
    'CR_CRIT_TAKEN_RANGED'=>        1 << 0x0E,
    'CR_CRIT_TAKEN_SPELL'=>         1 << 0x0F,
    'CR_HASTE_MELEE'=>              1 << 0x10,
    'CR_HASTE_RANGED'=>             1 << 0x11,
    'CR_HASTE_SPELL'=>              1 << 0x12,
    'CR_WEAPON_SKILL_MAINHAND'=>    1 << 0x13,
    'CR_WEAPON_SKILL_OFFHAND'=>     1 << 0x14,
    'CR_WEAPON_SKILL_RANGED'=>      1 << 0x15,
    'CR_EXPERTISE'=>                1 << 0x16,
    'CR_ARMOR_PENETRATION'=>        1 << 0x17,
));
$defineMap->pushToArray($enumCombatRating);

// Targets
$defineMap->createDefines(array(
    'NO_TARGET'=>                               0,
    'TARGET_SELF'=>                             1,
    'TARGET_RANDOM_ENEMY_CHAIN_IN_AREA'=>       2,                // only one spell has that, but regardless,  it's a target type after all
    'TARGET_RANDOM_FRIEND_CHAIN_IN_AREA'=>      3,
    'TARGET_4'=>                                4,
    'TARGET_PET'=>                              5,
    'TARGET_CHAIN_DAMAGE'=>                     6,
    'TARGET_AREAEFFECT_INSTANT'=>               7,                 // targets around provided destination point
    'TARGET_AREAEFFECT_CUSTOM'=>                8,
    'TARGET_INNKEEPER_COORDINATES'=>            9,                 // uses in teleport to innkeeper spells
    'TARGET_10'=>                               10,
    'TARGET_11'=>                               11,
    'TARGET_12'=>                               12,
    'TARGET_13'=>                               13,
    'TARGET_14'=>                               14,
    'TARGET_ALL_ENEMY_IN_AREA'=>                15,
    'TARGET_ALL_ENEMY_IN_AREA_INSTANT'=>        16,
    'TARGET_TABLE_X_Y_Z_COORDINATES'=>          17,                // uses in teleport spells and some other
    'TARGET_EFFECT_SELECT'=>                    18,                // highly depends on the spell effect
    'TARGET_19'=>                               19,
    'TARGET_ALL_PARTY_AROUND_CASTER'=>          20,
    'TARGET_SINGLE_FRIEND'=>                    21,
    'TARGET_CASTER_COORDINATES'=>               22,               // used only in TargetA, target selection dependent from TargetB
    'TARGET_GAMEOBJECT'=>                       23,
    'TARGET_IN_FRONT_OF_CASTER'=>               24,
    'TARGET_DUELVSPLAYER'=>                     25,
    'TARGET_GAMEOBJECT_ITEM'=>                  26,
    'TARGET_MASTER'=>                           27,
    'TARGET_ALL_ENEMY_IN_AREA_CHANNELED'=>      28,
    'TARGET_29'=>                               29,
    'TARGET_ALL_FRIENDLY_UNITS_AROUND_CASTER'=> 30,                // in TargetB used only with TARGET_ALL_AROUND_CASTER and in self casting range in TargetA
    'TARGET_ALL_FRIENDLY_UNITS_IN_AREA'=>       31,
    'TARGET_MINION'=>                           32,
    'TARGET_ALL_PARTY'=>                        33,
    'TARGET_ALL_PARTY_AROUND_CASTER_2'=>        34,                // used in Tranquility
    'TARGET_SINGLE_PARTY'=>                     35,
    'TARGET_ALL_HOSTILE_UNITS_AROUND_CASTER'=>  36,
    'TARGET_AREAEFFECT_PARTY'=>                 37,
    'TARGET_SCRIPT'=>                           38,
    'TARGET_SELF_FISHING'=>                     39,
    'TARGET_FOCUS_OR_SCRIPTED_GAMEOBJECT'=>     40,
    'TARGET_TOTEM_EARTH'=>                      41,
    'TARGET_TOTEM_WATER'=>                      42,
    'TARGET_TOTEM_AIR'=>                        43,
    'TARGET_TOTEM_FIRE'=>                       44,
    'TARGET_CHAIN_HEAL'=>                       45,
    'TARGET_SCRIPT_COORDINATES'=>               46,
    'TARGET_DYNAMIC_OBJECT_FRONT'=>             47,
    'TARGET_DYNAMIC_OBJECT_BEHIND'=>            48,
    'TARGET_DYNAMIC_OBJECT_LEFT_SIDE'=>         49,
    'TARGET_DYNAMIC_OBJECT_RIGHT_SIDE'=>        50,
    'TARGET_51'=>                               51,
    'TARGET_AREAEFFECT_CUSTOM_2'=>              52,
    'TARGET_CURRENT_ENEMY_COORDINATES'=>        53,               // set unit coordinates as dest only 16 target B imlemented
    'TARGET_LARGE_FRONTAL_CONE'=>               54,
    'TARGET_55'=>                               55,
    'TARGET_ALL_RAID_AROUND_CASTER'=>           56,
    'TARGET_SINGLE_FRIEND_2'=>                  57,
    'TARGET_58'=>                               58,
    'TARGET_59'=>                               59,
    'TARGET_NARROW_FRONTAL_CONE'=>              60,
    'TARGET_AREAEFFECT_PARTY_AND_CLASS'=>       61,
    'TARGET_62'=>                               62,
    'TARGET_DUELVSPLAYER_COORDINATES'=>         63,
    'TARGET_INFRONT_OF_VICTIM'=>                64,
    'TARGET_BEHIND_VICTIM'=>                    65,               // used in teleport behind spells caster/target dependent from spell effect
    'TARGET_RIGHT_FROM_VICTIM'=>                66,
    'TARGET_LEFT_FROM_VICTIM'=>                 67,
    'TARGET_68'=>                               68,
    'TARGET_69'=>                               69,
    'TARGET_70'=>                               70,
    'TARGET_71'=>                               71,
    'TARGET_RANDOM_NEARBY_LOC'=>                72,                // used in teleport onto nearby locations
    'TARGET_RANDOM_CIRCUMFERENCE_POINT'=>       73,
    'TARGET_74'=>                               74,
    'TARGET_75'=>                               75,
    'TARGET_DYNAMIC_OBJECT_COORDINATES'=>       76,
    'TARGET_SINGLE_ENEMY'=>                     77,
    'TARGET_POINT_AT_NORTH'=>                   78,                // 78-85 possible _COORDINATES at radius with pi/4 step around target in unknown order, N?
    'TARGET_POINT_AT_SOUTH'=>                   79,                // S?
    'TARGET_POINT_AT_EAST',                     80,                // 80/81 must be symmetric from line caster->target=> E (base at 82/83, 84/85 order) ?
    'TARGET_POINT_AT_WEST',                     81,                // 80/81 must be symmetric from line caster->target=> W (base at 82/83, 84/85 order) ?
    'TARGET_POINT_AT_NE'=>                      82,                // from spell desc: "(NE)"
    'TARGET_POINT_AT_NW'=>                      83,                // from spell desc: "(NW)"
    'TARGET_POINT_AT_SE'=>                      84,                // from spell desc: "(SE)"
    'TARGET_POINT_AT_SW'=>                      85,                // from spell desc: "(SW)"
    'TARGET_RANDOM_NEARBY_DEST'=>               86,                // "Test Nearby Dest Random" - random around selected destination
    'TARGET_SELF2'=>                            87,
    'TARGET_88'=>                               88,
    'TARGET_DIRECTLY_FORWARD'=>                 89,
    'TARGET_NONCOMBAT_PET'=>                    90,
    'TARGET_91'=>                               91,
    'TARGET_92'=>                               92,
    'TARGET_93'=>                               93,
    'TARGET_94'=>                               94,
    'TARGET_95'=>                               95,
    'TARGET_96'=>                               96,
    'TARGET_97'=>                               97,
    'TARGET_98'=>                               98,
    'TARGET_99'=>                               99,
    'TARGET_100'=>                              100,
    'TARGET_101'=>                              101,
    'TARGET_102'=>                              102,
    'TARGET_103'=>                              103,
    'TARGET_IN_FRONT_OF_CASTER_30'=>            104,
    'TARGET_105'=>                              105,
    'TARGET_106'=>                              106,
    'TARGET_107'=>                              107,
    'TARGET_108'=>                              108,
    'TARGET_109'=>                              109,
    'TARGET_110'=>                              110,
));
$defineMap->pushToArray($enumTargetTypes);

$defineMap->createDefines(array(
    'MECHANIC_NONE'=>               0,
    'MECHANIC_CHARM'=>              1,
    'MECHANIC_DISORIENTED'=>        2,
    'MECHANIC_DISARM'=>             3,
    'MECHANIC_DISTRACT'=>           4,
    'MECHANIC_FEAR'=>               5,
    'MECHANIC_GRIP'=>               6,
    'MECHANIC_ROOT'=>               7,
    'MECHANIC_PACIFY'=>             8,  //0 spells use this mechanic
    'MECHANIC_SILENCE'=>            9,
    'MECHANIC_SLEEP'=>              10,
    'MECHANIC_SNARE'=>              11,
    'MECHANIC_STUN'=>               12,
    'MECHANIC_FREEZE'=>             13,
    'MECHANIC_KNOCKOUT'=>           14,
    'MECHANIC_BLEED'=>              15,
    'MECHANIC_BANDAGE'=>            16,
    'MECHANIC_POLYMORPH'=>          17,
    'MECHANIC_BANISH'=>             18,
    'MECHANIC_SHIELD'=>             19,
    'MECHANIC_SHACKLE'=>            20,
    'MECHANIC_MOUNT'=>              21,
    'MECHANIC_INFECTED'=>           22,
    'MECHANIC_TURN'=>               23,
    'MECHANIC_HORROR'=>             24,
    'MECHANIC_INVULNERABILITY'=>    25,
    'MECHANIC_INTERRUPT'=>          26,
    'MECHANIC_DAZE'=>               27,
    'MECHANIC_DISCOVERY'=>          28,
    'MECHANIC_IMMUNE_SHIELD'=>      29, // Divine (Blessing) Shield/Protection and Ice Block
    'MECHANIC_SAPPED'=>             30,
    'MECHANIC_ENRAGED'=>            31,
));
$defineMap->pushToArray($enumMechanicTypes);

// Damage class
{
    define('SPELL_DAMAGE_CLASS_NONE',    0);
    define('SPELL_DAMAGE_CLASS_MAGIC',   1);
    define('SPELL_DAMAGE_CLASS_MELEE',   2);
    define('SPELL_DAMAGE_CLASS_RANGED',  3);
    
    $enumDamageClass = array('SPELL_DAMAGE_CLASS_NONE' => SPELL_DAMAGE_CLASS_NONE,
                            'SPELL_DAMAGE_CLASS_MAGIC' => SPELL_DAMAGE_CLASS_MAGIC,
                            'SPELL_DAMAGE_CLASS_MELEE' => SPELL_DAMAGE_CLASS_MELEE,
                            'SPELL_DAMAGE_CLASS_RANGED' => SPELL_DAMAGE_CLASS_RANGED);
}

/* Notepad ++ regex rules (temp)
CR_([A-Z0-9_]+)([ ]+)= (0+),
define('DISPEL_\1',\2\3); \4
'CR_\1' => CR_\1, */