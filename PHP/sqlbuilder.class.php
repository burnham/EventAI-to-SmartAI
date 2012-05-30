<?php

class NPC
{
    public function __construct($pdo, $npcId, $npcName) {
        $this->pdo = $pdo;
        $this->npcId = $npcId;
        $this->npcName = $npcName;
    }
    
    public function setEmoteWhenFleeing($apply) {
        foreach ($this->sai as $saiItem)
            $saiItem->setFleeingEmoteState($apply);
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
    
    public function getSmartScripts($write = true) {
        if (!$write) {
            foreach ($this->sai as $itr => $item)
                $item->toSQL($itr, false);
        }
        $output   = '';
        foreach ($this->sai as $itr => $item)
            $output .= $item->toSQL($itr);
        return substr($output, 0, - strlen(PHP_EOL) - 1) . ';' . PHP_EOL . PHP_EOL;
    }
    
    public function updataTalkActions($pairs) {
        foreach ($this->sai as $saiItem)
            $saiItem->updataTalkActions($pairs);
    }
    
    public function getCreatureText() {
        if (count($this->texts) == 0) return '';
        $output  = '-- Texts for ' . $this->npcName . PHP_EOL;
        $output .= 'DELETE FROM `creature_text` WHERE `entry`= ' . $this->npcId . ';' . PHP_EOL;
        $output .= 'INSERT INTO `creature_text` (`entry`,`groupid`,`id`,`text`,`type`,`language`,`probability`,`emote`,`duration`,`sound`,`comment`) VALUES' . PHP_EOL;
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
    
    public function updataTalkActions($pairs) {
        foreach ($this->data['actions'] as $i => $action) {
            $actionData = $this->data['actions'][$i];

            if (count($actionData) == 0 || $actionData['SAIAction'] != SMART_ACTION_TALK)
                continue;

            foreach ($pairs as $eaiEntry => $saiEntry) {
                if ($this->data['actions'][$i]['params'][0] != $eaiEntry)
                    continue;

                $this->data['actions'][$i]['params'] = array($saiEntry, 0, 0, 0, 0, 0);
            }
        }
    }
    
    public function setFleeingEmoteState($apply) {
        foreach ($this->data['actions'] as $i => $action) {
            if (count($action) == 0)
                break;
        
            if ($this->data['actions'][$i]['SAIAction'] == SMART_ACTION_FLEE_FOR_ASSIST)
                $this->data['actions'][$i]['params'][0] = $apply ? 1 : 0;
        }
    }
    
    public function toSQL($index, $write = true) {    
        //! We do not write anything, we only store texts.
        if (!$write) {
            foreach ($this->data['actions'] as $i => $action) {
                if (count($action) == 0)
                    break;
            
                if ($this->data['actions'][$i]['SAIAction'] == SMART_ACTION_TALK)
                    $this->_parent->addEAIText($this->data['actions'][$i]['dumpedTexts']);
            }
            return;
        }
        
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
            
            for ($j = 0; $j < 6; $j++)
                $outputString .= (isset($this->data['actions'][$i]['params'][$j]) ? $this->data['actions'][$i]['params'][$j] : 0) . ', ';
            
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
        if ($handle = fopen($file, 'a')) {
            fwrite($handle, $msg);
            fclose($handle);
        }
    }
}

class CreatureAiTexts
{
    private $creatureText = array();

    public function __construct($item, $parentNpc) {
        $this->_items = $item;
        $this->_parent = $parentNpc;
        $this->newIndexPairs = array();
    }
    
    public function toCreatureText() {
        $output = '';
        foreach ($this->_items as $item) {
            // Ignore flee emotes.
            if ($item->content_default == "%s attempts to run away in fear!") {
                $this->_parent->setEmoteWhenFleeing(true);
                continue;
            }

            $this->newIndexPairs[$item->entry] = $this->_parent->getGroupItr();
            
            $output .= '(' . $this->_parent->npcId . ', ';
            $output .= $this->_parent->getGroupItr() . ', ';
            $output .= $this->_parent->textIncrease() . ', ';
            $output .= '"' . addslashes($item->content_default) . '", ';
            $output .= $this->typeToSAI($item) . ', ';
            $output .= $item->language . ', 100, ';
            $output .= $item->emote . ', 0, ';
            $output .= $item->sound . ', "' . addslashes($this->_parent->npcName) . '"),' . PHP_EOL;
        }

        $this->_parent->updataTalkActions($this->newIndexPairs);
        
        return $output;
    }
    
    private function typeToSAI($item) {
        switch ($item->type)
        {
            case 0:
            case 1:
            case 2:
                return 12 + $item->type * 2;
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