<?php

class NPC
{
    public function __construct($pdo, $npcId, $npcName) {
        $this->pdo = $pdo;
        $this->npcId = $npcId;
        $this->npcName = $npcName;
    }

    private $sai = array();
    private $eai = array();
    private $texts = array();
    
    private $textsItr = 0;
    public function getTextItr() { return $this->textsItr; }
    public function textIncrease() { return $this->textsItr++; }
    public function resetTextItr() { $this->textsItr = 0; }

    private $groupItr = 0;
    public function getGroupItr() { return $this->groupItr; }
    public function groupIncrease() { $this->resetTextItr(); return $this->groupItr++;}

    public function addSAI($sai) { $this->sai[] = $sai; }
    public function addEAI($eai) { $this->eai[] = new EAI($eai, $this); }
    public function addEAIText($item) { $this->texts[] = new CreatureAiTexts($item, $this); }
    
    public function convertAllToSAI() {
        $oldDate = microtime(true);
        foreach ($this->eai as $eaiItem)
            $this->addSAI($eaiItem->toSAI($this->pdo));
    }
    
    public function getSmartScripts() {
        $output   = '';
        foreach ($this->sai as $itr => $item)
            $output .= $item->toSQL($itr);
        return substr($output, 0, - strlen(PHP_EOL) - 1) . ';' . PHP_EOL . PHP_EOL;
    }
    
    public function getCreatureText() {
        $output   = 'INSERT INTO `creature_text` (`entry`,`groupid`,`id`,`text`,`type`,`language`,`probability`,`emote`,`duration`,`sound`,`comment`) VALUES' . PHP_EOL;
        foreach ($this->texts as $itr => $item)
            $output .= $item->toCreatureText();
        return substr($output, 0, - strlen(PHP_EOL) - 1) . ';' . PHP_EOL . PHP_EOL;
    }
}

class SAI
{
    public function __construct($array, $parent) {
        $this->data = $array;
        $this->_parent = $parent;
    }
    
    public function toSQL($index) {
        $outputString = '-- SAI: ' . $this->data['npcName'] . PHP_EOL;
        $outputString .= 'SET @ENTRY := ' . $this->data['entryorguid'] . ';' . PHP_EOL;
        $outputString .= 'UPDATE creature_template SET AIName="SmartAI" WHERE entry = @ENTRY;' . PHP_EOL;
        $outputString .= 'DELETE FROM creature_ai_scripts WHERE creature_id = @ENTRY;' . PHP_EOL;
        if ($index == 0)
            $outputString .= 'INSERT INTO `smart_scripts` (`entryorguid`,`source_type`,`id`,`link`,`event_type`,`event_phase_mask`,`event_chance`,`event_flags`,`event_param1`,`event_param2`,`event_param3`,`event_param4`,`action_type`,`action_param1`,`action_param2`,`action_param3`,`action_param4`,`action_param5`,`action_param6`,`target_type`,`target_param1`,`target_param2`,`target_param3`,`target_x`,`target_y`,`target_z`,`target_o`,`comment`) VALUES' . PHP_EOL;
        
        foreach ($this->data['actions'] as $i => $action) {
            // Found an empty action. Means no action's following.
            if (count($action) == 0)
                break;

            $outputString .= '(@ENTRY, ';
            $outputString .= $this->data['source_type'] . ', ';
            $outputString .= ($index + $i - 1) . ', ';
            
            $link = 0;
            if (isset($this->data['actions'][$i + 1]) && count($this->data['actions'][$i + 1]) != 0)
                $link = ($index + $i);
            
            $outputString .= $link . ', ';

            if ($i == 1) $outputString .= $this->data['event_type'] . ', ';
            else         $outputString .= SMART_EVENT_LINK . ', ';

            $outputString .= $this->data['event_phase'] . ', ';
            $outputString .= $this->data['event_chance'] . ', ';
            $outputString .= $this->data['event_flags'] . ', ';
            
            if ($i == 1) {
                for ($j = 1; $j <= 4; $j++)
                    $outputString .= $this->data['event_params'][$j] . ', ';
            }
            else
                $outputString .= '0, 0, 0, 0, ';

            $outputString .= $this->data['actions'][$i]['SAIAction'] . ', ';
            
            if ($this->data['actions'][$i]['SAIAction'] == SMART_ACTION_TALK)
                $this->_parent->addEAIText($this->data['actions'][$i]['dumpedTexts']);
            
            for ($j = 0; $j < 6; $j++)
                $outputString .= $this->data['actions'][$i]['params'][$j] . ', ';
            
            $this->_parent->resetTextItr();
            $outputString .= '),' . PHP_EOL;
        }
        
        return $outputString;
    }
}

class EAI
{
    public function __construct($pdoObj, $parent) {
        $this->_eaiItem = $pdoObj;
        $this->_parent = $parent;
    }
    
    public function toSAI($pdoDriver) {
        $saiData = array();
        $saiData['entryorguid']  = intval($this->_eaiItem->npcId);
        $saiData['npcName']      = $this->_eaiItem->npcName;
        $saiData['source_type']  = 0;
        
        $saiData['event_type']   = Utils::convertEventToSAI($this->_eaiItem->event_type);
        $saiData['event_chance'] = intval($this->_eaiItem->event_chance);
        $saiData['event_flags']  = Utils::SAI2EAIFlag($this->_eaiItem->event_flags);
        
        $saiData['event_params'] = Utils::convertParamsToSAI($this->_eaiItem);
        $saiData['actions']      = array();

        for ($i = 1; $i < 4; $i++)
            $saiData['actions'][$i] = Utils::buildSAIAction($this->_eaiItem->{"action".$i."_type"},
                                        $this->_eaiItem->{"action".$i."_param1"}, $this->_eaiItem->{"action".$i."_param2"}, $this->_eaiItem->{"action".$i."_param3"}, $pdoDriver);

        $saiData['event_phase'] = Utils::generateSAIPhase($this->_eaiItem->event_inverse_phase_mask);
        
        $saiData['saiEntries'] = 0;
        for ($i = 1; $i < 4; $i++)
            if (count($saiData['actions'][$i]) != 0)
                $saiData['saiEntries']++;
        
        return new SAI($saiData, $this->_parent);
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
        if ($handle = fopen('workProgress.log', 'w+')) {
            fwrite($handle, date('d/m/Y H:i:s :: ') . $msg . PHP_EOL);
            fclose($handle);
        }
    }
    
    static function outSpecificFile($file, $msg) {
        if ($handle = fopen($file, 'w+')) {
            fwrite($handle, $msg);
            fclose($handle);
        }
    }
}

class CreatureAiTexts
{
    private $creatureText = array();

    public function __construct($item, $parentNpc) {
        $this->_item = $item;
        $this->_parent = $parentNpc;
    }
    
    public function toCreatureText() {
        $output  = '(' . $this->_parent->npcId . ', ';
        $output .= $this->_parent->textIncrease() . ', ';
        $output .= $this->_parent->getGroupItr() . ', ';
        $output .= '"' . addslashes($this->_item->content_default) . '", ';
        $output .= $this->typeToSAI() . ', ';
        $output .= $this->_item->language . ', 100, ';
        $output .= $this->_item->emote . ', 0, ';
        $output .= $this->_item->sound . ', "' . addslashes($this->_parent->npcName) . '"';
        return $output . '),' . PHP_EOL;
    }
    
    private function typeToSAI() {
        switch ($this->_item->type)
        {
            case 0:
            case 1:
            case 2:
                return 12 + $this->_item->type * 2;
            case 3:
                return 41;
            case 4:
                return 15;
            case 5:
                return 42; // YOU WIN
            case 6:
                if ($this->_item->entry == -544)
                    return 16;
                else if ($this->_item->entry == -860)
                    return 12;
            default:
                return -1; // Should never happen
        }
    }
}