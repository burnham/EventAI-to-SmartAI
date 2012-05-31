<?php

class NPC
{
    public function __construct($pdo, $npcId, $npcName) {
        $this->pdo = $pdo;
        $this->npcId = $npcId;
        $this->npcName = $npcName;
    }
    
    public function countSQLRows($isSAI = false) {
        if ($isSAI)
            return count($this->sai);
        return count($this->eai);
    }

    public function setEmoteWhenFleeing($apply) {
        foreach ($this->sai as $saiItem)
            $saiItem->setFleeingEmoteState($apply);
        return '';
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
    public function addText($item) {
        $this->texts[] = new CreatureAiText($item, $this);
    }

    public function convertAllToSAI() {
        $oldDate = microtime(true);
        foreach ($this->eai as $eaiItem)
            $this->addSAI($eaiItem->toSAI($this->pdo));
    }

    public function getSmartScripts($write = true) {
        if (!$write) {
            foreach ($this->sai as $itr => $item)
                $item->toSQL($itr, false);
            return;
        }

        $output   = '';
        foreach ($this->sai as $itr => $item)
            $output .= $item->toSQL($itr);
        return substr($output, 0, - strlen(PHP_EOL) - 1) . ';' . PHP_EOL . PHP_EOL;
    }

    public function updateTalkActions($pairs) {
        foreach ($this->sai as $saiItem)
            $saiItem->updataTalkActions($pairs);
    }

    public function getCreatureText() {
        $qty = count($this->texts);
        foreach ($this->texts as $textItem)
            if ($textItem->hasFleeEmote())
                $qty--;

        if ($qty == 0)
            return '';

        $output  = '-- Texts for ' . $this->npcName . PHP_EOL;
        $output .= 'DELETE FROM `creature_text` WHERE `entry`= ' . $this->npcId . ';' . PHP_EOL;
        $output .= 'INSERT INTO `creature_text` (`entry`,`groupid`,`id`,`text`,`type`,`language`,`probability`,`emote`,`duration`,`sound`,`comment`) VALUES' . PHP_EOL;
        foreach ($this->texts as $item)
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
    var_dump(gettype($this->data['actions']));
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
            for ($i = 1; $i <= 3; $i++) {
                $action = $this->data['actions'][$i];
                
                if (!isset($action['SAIAction']))
                    continue;

                if ($action['SAIAction'] == SMART_ACTION_TALK) {
                    foreach ($action['dumpedTexts'] as $text)
                        $this->_parent->addText($text);
                }
            }
            return;
        }

        $outputString = '-- SAI: ' . $this->data['npcName'] . PHP_EOL;
        $outputString .= 'SET @ENTRY := ' . $this->data['entryorguid'] . ';' . PHP_EOL;
        $outputString .= 'UPDATE creature_template SET AIName="SmartAI" WHERE entry = @ENTRY;' . PHP_EOL;
        $outputString .= 'DELETE FROM creature_ai_scripts WHERE creature_id = @ENTRY;' . PHP_EOL;
        if ($index == 0)
            $outputString .= 'INSERT INTO `smart_scripts` (`entryorguid`,`source_type`,`id`,`link`,`event_type`,`event_phase_mask`,`event_chance`,`event_flags`,`event_param1`,`event_param2`,`event_param3`,`event_param4`,`action_type`,`action_param1`,`action_param2`,`action_param3`,`action_param4`,`action_param5`,`action_param6`,`target_type`,`target_param1`,`target_param2`,`target_param3`,`target_x`,`target_y`,`target_z`,`target_o`,`comment`) VALUES' . PHP_EOL;

        for ($i = 1; $i <= 3; $i++) {
            $action = $this->data['actions'][$i];
        
            // Found an empty action. Means no action's following.
            //! Note: Invalid for TWO EAIs. Fix them by hand before running this script.
            //! SELECT * FROM creature_ai_scripts WHERE action1_type= 0 AND (action2_type != 0 OR action3_type != 0);
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

            if ($i == 1)
                for ($j = 1; $j <= 4; $j++)
                    $outputString .= $this->data['event_params'][$j] . ', ';
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
        $saiData['actions']      = Utils::buildSAIAction($this->_eaiItem, $pdoDriver);

        $saiData['event_phase']  = Utils::generateSAIPhase($this->_eaiItem->event_inverse_phase_mask);

        $saiData['saiEntries'] = 0;
        for ($i = 1; $i < 4; $i++)
            if (count($saiData['actions'][$i]) != 0)
                $saiData['saiEntries']++;

        return new SAI($saiData, $this->_parent);
    }
}

class CreatureAiText
{
    public function __construct($item, $parentNpc) {
        $this->_item = $item;
        $this->_parent = $parentNpc;
        $this->newIndexPair = array();
    }
    
    public function hasFleeEmote() {
        return ($this->_item->content_default == "%s attempts to run away in fear!");
    }

    public function toCreatureText() {
        // Ignore flee emotes.
        if ($this->hasFleeEmote())
            return $this->_parent->setEmoteWhenFleeing(true);

        $this->newIndexPair[$this->_item->entry] = $this->_parent->getGroupItr();

        $output  = '(' . $this->_parent->npcId . ', ';
        $output .= $this->_parent->getGroupItr() . ', ';
        $output .= $this->_parent->textIncrease() . ', ';

        $content = addslashes($this->_item->content_default);

        $output .= '"' . str_replace("\'", "'", $content) . '", ';
        $output .= $this->typeToSAI($this->_item) . ', ';
        $output .= $this->_item->language . ', 100, ';
        $output .= $this->_item->emote . ', 0, ';
        $output .= $this->_item->sound . ', "' . addslashes($this->_parent->npcName) . '"),' . PHP_EOL;

        $this->_parent->updateTalkActions($this->newIndexPair);

        return $output;
    }

    private function typeToSAI($item) {
        // Too lazy to add enums here.
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
