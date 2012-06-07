<?php
error_reporting(E_ALL | E_STRICT);
require('../lib/bootstrap.php');
require('../data/shareddefines.php');

//-------------------------------------------//
//--------------- Functions -----------------//
//-------------------------------------------//

// Loop through all entries in the array and convert the ones into a 0x00000000 format.
function ConvertFieldsTo8BitFlags(&$record)
{
    $toConvert = array('Attributes', 'AttributesEx', 'AttributesEx2', 'AttributesEx3', 'AttributesEx4', 'AttributesEx5', 'AttributesEx6', 'AttributesExG', 'SpellFamilyFlags1', 'SpellFamilyFlags2', 'SpellFamilyFlags3', 'InterruptFlags', 'AuraInterruptFlags', 'ChannelInterruptFlags', 'EffectSpellClassMaskA1', 'EffectSpellClassMaskA2', 'EffectSpellClassMaskA3', 'EffectSpellClassMaskB1', 'EffectSpellClassMaskB2', 'EffectSpellClassMaskB3', 'EffectSpellClassMaskC1', 'EffectSpellClassMaskC2', 'EffectSpellClassMaskC3');
    foreach ($record as $key => $value)
        if (in_array($key, $toConvert))
        {
            $record[$key] = sprintf('0x%08X', $value);
            define('OLD' . $key, $value); // For detailing filters
        }
    
    return $record;
}

function AppendTimeToField(&$field, $time)
{
    return $field .= " " . $time;
}

function FixCharset(&$record)
{
    foreach ($record as $key => $value)
        if (!is_numeric($record[$key]))
            $record[$key] = utf8_decode($record[$key]);
}

function ExtendStances(&$record, $enumStances)
{
    $buffer = "(";
    foreach ($enumStances as $key => $value)
        if ($record & $value && $value != -1)
            $buffer .= $key . ", ";
     
    $buffer = substr($buffer, 0, -2);
    if (strlen($buffer) == 0)
        return;
    
    $buffer .= ")";
    
    return $record .= " " . $buffer;
}

function GetAurasEffects(&$record, $enumSpellAuras)
{
    for ($i = 1; $i < 4; $i++)
        foreach ($enumSpellAuras as $key => $value)
            if ($record['EffectAuraID' . $i] == $value)
                $record['EffectAuraID' . $i] .= ' (' . $key . ')';
}

function GetFamilyName(&$field, $enum)
{
    foreach ($enum as $key => $value)
        if ($field == $value)
        {
            $field .= ' (' . $key . ')';
            break;
        }
}

function DropUnusedEntries(&$record)
{
    foreach ($record as $key => $value)
        if (strpos($key, "Unused"))
            unset($record[$key]);
}

function ExtendPreventionType(&$field, $enum)
{
    $buffer = "(";
    foreach ($enum as $key => $value)
        if ($field & $value)
            $buffer .=  $key . ', ';
    
    $buffer = substr($buffer, 0, -2);
    if (strlen($buffer) == 0)
        return;
    
    $buffer .= ")";
    return $field .= ' ' . $buffer;
}

function ExtendAttr(&$field, $enum, $passedCheck)
{
    $buffer = "(";

    foreach ($enum as $k => $v)
        if ($passedCheck & $v)
            $buffer .= $k . ", ";
            
    $buffer = substr($buffer, 0, -2);
    if (strlen($buffer) == 0)
        return;
    
    $buffer .= ")";
    return $field .= ' ' . $buffer;
}

function ExtendDispelType(&$field, $enum)
{
    foreach ($enum as $k => $v)
        if ($field & $v)
            return $field .= ' (' . $k . ')';
}

function ExtendSpellEffect(&$record, $enum)
{
    for ($i = 1; $i < 4; $i++)
        foreach ($enum as $key => $value)
            if ($record['Effect' . $i] == $value)
                $record['Effect' . $i] .= ' (' . $key . ')';  
}

function ExtendPowerType(&$field, $enum)
{
    foreach ($enum as $k => $v)
        if ($field == $v)
            return $field .= ' (' . $k . ')';
}

function ExtendTargetType(&$record, $enum)
{
    for ($i = 1; $i < 4; $i++)
        foreach ($enum as $k => $v)
        {
            if ($v == $record['EffectImplicitTargetA' . $i])
                $record['EffectImplicitTargetA' . $i] .= ' (' . $k . ')';
            if ($v == $record['EffectImplicitTargetB' . $i])
                $record['EffectImplicitTargetB' . $i] .= ' (' . $k . ')';
        }
}

function ExtendMechanic(&$field, $enum)
{
    foreach ($enum as $k => $v)
        if ($field == $v)
        {
            $field .= ' (' . $k . ')';
            break;
        }
}

function ExtendDamageClass(&$field, $enum)
{
    foreach ($enum as $k => $v)
        if ($v == $field)
        {
            $field .= ' (' . $k . ')';
            break;
        }
}

function ExtendSchoolMask(&$field, $enum)
{
    foreach ($enum as $k => $v)
        if ($v == $field)
        {
            $field .= ' (' . $k . ')';
            break;
        }
}

//-------------------------------------------//
//------------ End of functions -------------//
//-------------------------------------------//

// Open the given DBC (ensure read-access)
$dbc = new DBC('./dbcs/Spell.dbc', DBCMap::fromINI('./maps/Spell.ini'));

$record = $dbc->getRecordById($_GET['id'])->extract();

// Processing the array
DropUnusedEntries($record);
ConvertFieldsTo8BitFlags($record);
AppendTimeToField($record['RecoveryTime'], 'ms');
AppendTimeToField($record['CategoryRecoveryTime'], 'ms');
AppendTimeToField($record['StartRecoveryTime'], 'ms');
AppendTimeToField($record['StartRecoveryCategory'], 'ms');
FixCharset($record);
ExtendStances($record['Stances1'], $enumStances);
ExtendStances($record['Stances2'], $enumStances);
ExtendStances($record['StancesNot1'], $enumStances);
ExtendStances($record['StancesNot2'], $enumStances);
GetAurasEffects($record, $enumSpellAuras);
GetFamilyName($record['SpellFamilyName'], $enumSpellFamily);
ExtendPreventionType($record['PreventionType'], $enumSpellPreventionType);
ExtendAttr($record['Attributes']   , $enumSpellAttr0, OLDAttributes);
ExtendAttr($record['AttributesEx'] , $enumSpellAttr1, OLDAttributesEx);
ExtendAttr($record['AttributesEx2'], $enumSpellAttr2, OLDAttributesEx2);
ExtendAttr($record['AttributesEx3'], $enumSpellAttr3, OLDAttributesEx3);
ExtendAttr($record['AttributesEx4'], $enumSpellAttr4, OLDAttributesEx4);
ExtendAttr($record['AttributesEx5'], $enumSpellAttr5, OLDAttributesEx5);
ExtendAttr($record['AttributesEx6'], $enumSpellAttr6, OLDAttributesEx6);
ExtendAttr($record['AttributesExG'], $enumSpellAttrG, OLDAttributesExG);
ExtendDispelType($record['Dispel'], $enumDispelTypes);
ExtendSpellEffect($record, $enumSpellEffect);
ExtendPowerType($record['PowerType'], $enumPowerType);
ExtendTargetType($record, $enumTargetTypes);
ExtendMechanic($record['Mechanic'], $enumMechanicTypes);
ExtendMechanic($record['EffectMechanic1'], $enumMechanicTypes);
ExtendMechanic($record['EffectMechanic2'], $enumMechanicTypes);
ExtendMechanic($record['EffectMechanic3'], $enumMechanicTypes);
ExtendDamageClass($record['DmgClass'], $enumDamageClass);
ExtendSchoolMask($record['SchoolMask'], $enumSchoolMasks);
?>
<html>
<head>
    <title><?
    
    echo $record['SpellNameLang2']; 
    if (strlen($record['RankText2']) !== 0)
        echo ' (' . $record['RankText2'] . ')';
    
    ?></title>
    
    <style type="text/css">
    #inside
    {
        border: 1px solid #404040;
        background-color: #242424;
        padding: 10px;
        min-height: 550px;
        -webkit-border-radius: 2px;
        -moz-border-radius: 2px;
        border-radius: 2px;
    }
    
    html
    {
        background-color: black;
        margin: 0;
        padding: 0;
        font-family: Arial,sans-serif;
        font-size: 13px;
        color: white;
    }
    
    #wrapper { min-width: 980px; max-width: 1240px; margin: 0 auto; }
    
    .toptabs, .toptabs a { height: 32px; }
    .toptabs dl { padding: 0; margin: 0; }
    .toptabs dt { display: block; float: left; margin: 0 3px 0 0; padding: 0; }
    .toptabs a.unlinked { cursor: default; }
    
    a 
    {
        color: #FFD100;
        cursor: pointer;
        outline: none;
    }
    
    .toptabs a 
    {
        display: block;
        overflow: hidden;
        text-align: left;
        white-space: nowrap;
        line-height: 37px;
        padding-left: 10px;
        font-family: Arial,sans-serif;
        font-weight: bold;
        font-size: 14px;
        text-decoration: none;
        text-transform: uppercase;
        color: #FFCD55;
        cursor: pointer;
        background: url(./tabs.gif) left 0 no-repeat;
    }
    
    .toptabs a:hover, .toptabs a:hover span
    {
        background-position: right -32px!important;
    }
    
    .toptabs a.active 
    {
        position: relative;
        top: 1px;
        line-height: 32px;
        background-position: left -64px!important;
        color: white!important;
    }
    
    .toptabs a.active span { background-position: right -64px!important; }
    
    .toptabs a span 
    {
        display: block;
        padding-right: 10px;
        background: url(./tabs.gif) right 0 no-repeat;
        height: 32px;
    }
    
    .toptabs dt 
    {
        display: block;
        float: left;
        margin: 0 3px 0 0;
        padding: 0;
    }
    
    .topbar 
    {
        background: #383838;
        border: 1px solid #484848;
        height: 30px;
        overflow: hidden;
        -webkit-border-radius: 2px;
        -moz-border-radius: 2px;
        border-radius: 2px;
    }
    
    .topbar-search { float: right; position: relative; right: 3px; top: 3px; }
    .topbar-search a 
    {
        width: 20px;
        height: 20px;
        display: block;
        position: absolute;
        right: 3px;
        top: 2px;
        background: url(./zoom.gif) 2px 2px no-repeat;
    }
    
    form { padding: 0; margin: 0; display: inline; }
    
    .topbar-search input 
    {
        font-size: 13px;
        border: 1px solid #adadad;
        background: white url(./input-bg.gif) repeat-x;
        outline: 0;
        padding: 3px;
        margin: 0;
        width: 250px;
        -webkit-border-radius: 3px;
        -moz-border-radius: 3px;
        border-radius: 3px;
    }
    
    .breadcrumb {
        cursor: default;
        font-size: 15px;
        padding: 5px 0 5px 20px;
        background: url(./favicon.png) left center no-repeat;
    }
    
    span.breadcrumb-arrow { padding-right: 17px; background: url(./arrow-right.gif) right center no-repeat; }
    
    #pre 
    {
        background: #141414;
        padding: 10px;
        border-left: 1px solid #101010;
        border-right: 1px solid #101010;
    }
    
    .topbar-buttons { line-height: 30px; padding-left: 3px; }
    
    #inside p
    {
        background-color: #070C21;
        border: 1px solid #CFCFCF;
        -webkit-border-radius: 4px;
        -moz-border-radius: 4px;
        border-radius: 4px;
        font-family: Verdana,sans-serif;
        font-size: 12px;
        line-height: 17px;
        -moz-box-shadow: 0 0 1px 1px #000;
        -webkit-box-shadow: 0 0 1px 1px #000;
        box-shadow: 0 0 1px 1px #000;
        padding: 7px;
        width: 85%;
        margin-left: 17px;
    }
    
    #inside h4:before { content: ' » '; }
    
    #inside h4
    {
        margin-bottom: -5px;
    }
    
    #inside p b 
    {
        display: block;
        float: left;
        width: 280px;
    }
    </style>
</head>

<body>
    <div id="wrapper">
        <div class="toptabs" id="toptabs">
            <dl>
                <dt>
                    <a href="javascript:;" class="unlinked active">
                        <span><big>I</big>ndex</span>
                    </a>
                </dt>
                <dt>
                    <a href="">
                        <span><big>R</big>echercher un sort</span>
                    </a>
                </dt>
                <dt>
                    <a href="">
                        <span><big>A</big>dministration</span>
                    </a>
                </dt>
            </dl>
        </div>

        <div class="topbar" id="topbar">
            <div class="topbar-search">
                <form action="/search">
                    <input name="q" value="" autocomplete="off">
                </form><a href="javascript:;"></a>
            </div>
            <div class="topbar-buttons"><span>Le but de cet outil est de compléter SpellWork en vous indiquant quel champ changer dans le core.</span></div>
        </div>
        
        <div id="pre">
            <div class="breadcrumb" style="">
                <span class="breadcrumb-arrow">Base de données</span>
                <span class="breadcrumb-arrow">
                    <a href="">Sorts</a>
                </span>
                <span><?php echo $record['SpellNameLang2']; ?></a></span>
            </div>
        </div>
        
        <div id="inside">
            <h3 style="border-bottom: 1px solid white;">ID <?php echo $record['Entry']; ?> - <?php echo $record['SpellNameLang2']; ?></h3>
            <h4>Description:</h4>
            <p>
                <?php echo $record['DescriptionLang2']; ?>
            </p>
            <h4>Tooltip:</h4>
            <p>
                <?php echo $record['ToolTipLang2']; ?>
            </p>
            
            <p>
                <b>SpellIconID</b> = <?php echo $record['SpellIconID']; ?><br />
                <b>spellInfo->ActiveIconID</b> = <?php echo $record['ActiveIconID']; ?><br />
                <?php 
                if ($record['AreaGroupId'] != 0)
                    echo '<b>spellInfo->AreaGroupId</b> = ' . $record['AreaGroupId'] . '<br />';
                if ($record['Attributes'] != 0)
                    echo '<b>spellInfo->Attributes</b> = ' . $record['Attributes'] . '<br />';
                if ($record['AttributesEx'] != 0)
                    echo '<b>spellInfo->AttributesEx</b> = ' . $record['AttributesEx'] . '<br />';
                for ($i = 2; $i < 7; $i++)
                    if ($record['AttributesEx' . $i] != 0)
                            echo '<b>spellInfo->AttributesEx' . $i . '</b> = ' . $record['AttributesEx' . $i] . '<br />';
                if ($record['AttributesExG'] != 0)
                    echo '<b>spellInfo->AttributesEx7</b> = ' . $record['AttributesExG'] . '<br />';
                ?>
                <b>spellInfo->AuraInterruptFlags</b> = <?php echo $record['AuraInterruptFlags']; ?><br />
                <b>spellInfo->baseLevel</b> = <?php echo $record['SpellBaseLevel']; ?><br />
                <b>spellInfo->casterAuraSpell</b> = <?php echo $record['CasterAuraSpell']; ?><br />
                <b>spellInfo->CasterAuraState</b> = <?php echo $record['CasterAuraState']; ?><br />
                <b>spellInfo->CasterAuraStateNot</b> = <?php echo $record['CasterAuraStateNot']; ?><br />
                <b>spellInfo->CastingTimeIndex</b> = <?php echo $record['CastingTimeIndex']; ?><br />
                <b>spellInfo->Category</b> = <?php echo $record['Category']; ?><br />
                <b>spellInfo->ChannelInterruptFlags</b> = <?php echo $record['ChannelInterruptFlags']; ?><br />
                <b>spellInfo->Dispel</b> = <?php echo $record['Dispel']; ?><br />
                <b>spellInfo->DmgClass</b> = <?php echo $record['DmgClass']; ?><br />
                <b>spellInfo->DurationIndex</b> = <?php echo $record['DurationIndex']; ?><br />
                <?php
                for ($i = 1; $i < 4; $i ++)
                {
                    if ($record['Effect' . $i] == '0 (NO EFFECT)')
                        continue;
                    echo '<font style="font-size: 14px">------------------------------------------------------------';
                    echo ' Effect #' . $i . ' ';
                    echo '-----------------------------------------------------------</font><br />';
                    echo '<b>spellInfo->Effect[' . ($i - 1) . ']</b> = ' . $record['Effect' . $i] . '<br />';
                    echo '<b>spellInfo->EffectAmplitude[' . ($i - 1) . ']</b> = ' . $record['EffectPeriod' . $i] . '<br />';
                    echo '<b>spellInfo->EffectApplyAuraName[' . ($i - 1) . ']</b> = ' . $record['EffectAuraID' . $i] . '<br />';
                    echo '<b>spellInfo->EffectBasePoints[' . ($i - 1) . ']</b> = ' . ($record['EffectBasePoints' . $i] + 1) . '<br />'; // Why + 1 ?
                    echo '<b>spellInfo->EffectBonusMultiplier[' . ($i - 1) . ']</b> = ' . $record['EffectMultipleValue' . $i] . '<br />';
                    echo '<b>spellInfo->EffectChainTarget[' . ($i - 1) . ']</b> = ' . $record['EffectChainTarget' . $i] . '<br />';
                    echo '<b>spellInfo->EffectDamageMultiplier[' . ($i - 1) . ']</b> = ' . $record['DmgMultiplier' . $i] . '<br />';
                    echo '<b>spellInfo->EffectDieSides[' . ($i - 1) . ']</b> = ' . $record['EffectDieSides' . $i] . '<br />';
                    echo '<b>spellInfo->EffectImplicitTargetA[' . ($i - 1) . ']</b> = ' . $record['EffectImplicitTargetA' . $i] . '<br />';
                    echo '<b>spellInfo->EffectImplicitTargetB[' . ($i - 1) . ']</b> = ' . $record['EffectImplicitTargetB' . $i] . '<br />';
                    echo '<b>spellInfo->EffectItemType[' . ($i - 1) . ']</b> = ' . $record['EffectItemType' . $i] . '<br />';
                    echo '<b>spellInfo->EffectMechanic[' . ($i - 1) . ']</b> = ' . $record['EffectMechanic' . $i] . '<br />';
                    echo '<b>spellInfo->EffectMiscValue[' . ($i - 1) . ']</b> = ' . $record['EffectMiscValue' . $i] . '<br />';
                    echo '<b>spellInfo->EffectMiscValueB[' . ($i - 1) . ']</b> = ' . $record['EffectMiscValueB' . $i] . '<br />';
                    echo '<b>spellInfo->EffectPointsPerComboPoint[' . ($i - 1) . ']</b> = ' . $record['EffectPointsPerComboPoint' . $i] . '<br />';
                    echo '<b>spellInfo->EffectRadiusIndex[' . ($i - 1) . ']</b> = ' . $record['EffectRadiusIndex' . $i] . '<br />';
                    echo '<b>spellInfo->EffectRealPointsPerLevel[' . ($i - 1) . ']</b> = ' . $record['EffectRealPointsPerLevel' . $i] . '<br />';
                    for ($j = 0; $j < 3; $j++)
                    {
                        switch ($j)
                        {
                            case 0: $sub = 'A'; break;
                            case 2: $sub = 'B'; break;
                            case 1: $sub = 'C'; break;
                        }
                        echo '<b>spellInfo->EffectSpellClassMask[' . ($i - 1) . '][' . $j . ']</b> = ' . $record['EffectSpellClassMask' . $sub . $i] . '<br />';
                    }
                    echo '<b>spellInfo->EffectTriggerSpell[' . ($i - 1) . ']</b> = ' . $record['EffectTriggerSpell' . $i] . '<br />';
                }
                ?>
            </p>
    <?php
        // Output the array
        echo '  <pre style="font-family: Consolas; font-size: 12px; width: 45%">';
        print_r($record);
        echo '</pre>';
    ?>
        </div>
    </div>
</body>