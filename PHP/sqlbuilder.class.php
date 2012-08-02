<?php

class NPC
{
    private $sai = array();
    private $eai = array();
    private $texts = array();

    public  $npcId;
    public  $npcName;

    private $textGroupId = 0;
    private $textId      = 0;
    private $saiItemId   = 0;
    private $linkItr     = 0;
    private $eventCache  = array();

    public function __construct($npcId, $npcName) {
        $this->npcId      = $npcId;
        $this->npcName    = $npcName;
        $this->saiItemId  = 0;
        $this->dumpSpells = (Factory::createOrGetDBCWorker() !== false);
    }

    public function countSQLRows($isSAI = false) {
        if ($isSAI)
            return count($this->sai);
        return count($this->eai);
    }

    public function setEmoteWhenFleeing($apply) {
        foreach ($this->sai as $saiItem)
            $saiItem->setFleeingEmoteState($apply);
    }

    public function addSAI($sai) {
        $this->sai[] = $sai;
    }

    public function addEAI($eai) {
        $this->eai[] = new EAI($eai, $this);
    }

    public function addText($item) {
        $textObj = new CreatureAiText($item, $this);
        $this->texts[] = $textObj;
        return $textObj;
    }

    public function increaseTextGroupId() { $this->resetTextId(); $this->textGroupId++; return $this; }
    public function getGroupId()   { return $this->textGroupId; }

    public function resetTextId()         { $this->textId = 0; }
    public function getTextId()    { $this->textId++; return $this->textId - 1; }

    public function getSaiIndex()  { return $this->saiItemId; }
    public function increaseSaiIndex()    { $this->saiItemId++; return $this; }
    public function resetSaiIndex()       { $this->saiItemId = 0; }

    public function getLinkIndex()        { return $this->linkItr; }
    public function increaseLinkIndex()   { $this->linkItr += 1; }
    public function setLinkIndex($val)    { $this->linkItr = $val; }

    public function addEventToCache($event) {
        $item = array(
            'type'    => $event['event_type'],
            'phase'   => $event['event_phase'],
            'flags'   => $event['event_flags'],
            'chance'  => $event['event_chance'],
            'params'  => $event['event_params']
        );
    }

    public function hasEventInCache($event) {
        foreach ($this->eventCache as $item)
            if ($item['type']         == $event['event_type']      && $item['phase']     == $event['event_phase']
                && ($item['flags']    == $event['event_flags']     || $item['flags']     <= 1)
                && $item['chance']    == $event['event_chance']
                && $item['params'][1] == $event['event_params'][1] && $item['params'][2] == $event['event_params'][2]
                && $item['params'][3] == $event['event_params'][3] && $item['params'][4] == $event['event_params'][4])
                return true;
            return false;
    }

    public function convertAllToSAI() {
        foreach ($this->eai as $eaiItem)
            $this->addSAI($eaiItem->toSAI());
        unset($this->eai); // Save some memory
    }

    public function updateTalkActions($eaiEntry, $saiEntry) {
        foreach ($this->sai as $saiItem)
            $saiItem->updateTalkActions($eaiEntry, $saiEntry);
    }

    public function getSmartScripts($write = true) {
        if (!$write) {
            foreach ($this->sai as $itr => $item)
                $item->toSQL(false);

            unset($item); // Save some memory
            return;
        }

        $this->resetSaiIndex();

        $output = '-- ' . $this->npcName . ' SAI' . PHP_EOL;
        $output .= 'SET @ENTRY := ' . $this->npcId . ';' . PHP_EOL;
        $output .= 'UPDATE `creature_template` SET `AIName`=\'SmartAI\' WHERE `entry`=@ENTRY;' . PHP_EOL;
        $output .= 'DELETE FROM `creature_ai_scripts` WHERE `creature_id`=@ENTRY;' . PHP_EOL;
        $output .= 'DELETE FROM `smart_scripts` WHERE `entryorguid`=@ENTRY AND `source_type`=0;' . PHP_EOL; # The reason default source_type is 0 is because EventAI doesn't support timed actionlists.
        $output .= 'INSERT INTO `smart_scripts` (`entryorguid`,`source_type`,`id`,`link`,`event_type`,`event_phase_mask`,`event_chance`,`event_flags`,`event_param1`,`event_param2`,`event_param3`,`event_param4`,`action_type`,`action_param1`,`action_param2`,`action_param3`,`action_param4`,`action_param5`,`action_param6`,`target_type`,`target_param1`,`target_param2`,`target_param3`,`target_x`,`target_y`,`target_z`,`target_o`,`comment`) VALUES' . PHP_EOL;

        foreach ($this->sai as $item)
            $output .= $item->toSQL();

        unset($item);

        return substr($output, 0, - strlen(PHP_EOL) - 1) . ';' . PHP_EOL . PHP_EOL;
    }

    public function getCreatureText() {
        $qty = count($this->texts);
        foreach ($this->texts as $textItem)
            if ($textItem->isFleeEmote())
                $qty--;

        unset($textItem); // Save some memory

        if ($qty == 0)
            return '';

        $output  = '-- Texts for ' . $this->npcName . PHP_EOL;
        $output .= 'DELETE FROM `creature_text` WHERE `entry`= ' . $this->npcId . ';' . PHP_EOL;
        $output .= 'INSERT INTO `creature_text` (`entry`,`groupid`,`id`,`text`,`type`,`language`,`probability`,`emote`,`duration`,`sound`,`comment`) VALUES' . PHP_EOL;
        foreach ($this->texts as $item)
            $output .= $item->toCreatureText();

        unset($item); // Save some memory

        return substr($output, 0, - strlen(PHP_EOL) - 1) . ';' . PHP_EOL . PHP_EOL;
    }
}

class SAI
{
    public function __construct($array, $parent) {
        $this->data = $array;
        $this->_parent = $parent;
    }

    public function updateTalkActions($eaiValue, $saiValue) {
        for ($i = 1; $i <= 3 ; $i++) {
            if (!isset($this->data['actions'][$i]))
                continue;

            $action = $this->data['actions'][$i];

            if (count($action) == 0 || $action['SAIAction'] != SMART_ACTION_TALK || $eaiValue != $action['params'][0])
                continue;

            $this->data['actions'][$i]['params'] = array($saiValue, 0, 0, 0, 0, 0);
        }

        unset($eaiValue, $saiValue); // Save some memory
    }

    public function setFleeingEmoteState($apply) {
        $size = count($this->data['actions']);
        for ($i = 1; $i < $size; $i++) {
            $action = &$this->data['actions'][$i];
            if (count($action) == 0)
                break;

            if ($action['SAIAction'] == SMART_ACTION_FLEE_FOR_ASSIST)
                $action['params'][0] = ($apply ? 1 : 0);
        }
        unset($i, $size); // Save some memory
    }

    public function toSQL($write = true) {
        //! We do not write anything, we only store texts.
        if (!$write) {
            for ($i = 1; $i <= 3; $i++) {
                if (!isset($this->data['actions'][$i]))
                    continue;

                $action = $this->data['actions'][$i];
                
                if (count($action) == 0)
                    continue;

                if ($action['SAIAction'] == SMART_ACTION_TALK) {
                    foreach ($action['extraData'] as $text)
                        $this->_parent->addText($text)->setGroupId($this->_parent->getGroupId())->setTextId($this->_parent->getTextId());
                    $this->_parent->increaseTextGroupId();
                    unset($text); // Save some memory
                }
            }
            return;
        }

        $outputString = '';

        // Fast-remove all flee emotes
        // Need to be done before processing, else linking is fooked
        foreach ($this->data['actions'] as $i => $action)
            if ($action['SAIAction'] == SMART_ACTION_TALK && $action['params'][0] == -47)
                unset($this->data['actions'][$i]);

        foreach ($this->data['actions'] as $i => $action) {
            // Found an empty action. Means no action's following.
            //! Note: Invalid for TWO EAIs. Fix them by hand before running this script.
            //! SELECT * FROM creature_ai_scripts WHERE action1_type= 0 AND (action2_type != 0 OR action3_type != 0);
            if (count($action) == 0)
                break;

            $outputString .= '(@ENTRY,';
            $outputString .= $this->data['source_type'] . ',';
            $outputString .= $this->_parent->getSaiIndex() . ',';

            $linked = false;
            if ($this->_parent->hasEventInCache($this->data)
                || (isset($this->data['actions'][$i + 1]) && count($this->data['actions'][$i + 1]) != 0)) {
                $this->_parent->increaseLinkIndex();
                $outputString .= $this->_parent->getLinkIndex() . ',' . $this->data['event_type'] . ',';
                $linked = true;
            }
            else
            {
                $this->_parent->setLinkIndex($this->_parent->getSaiIndex() + 1); // +1 because index is not yet updated
                if (count($this->data['actions']) == 1)
                    $outputString .= '0,' . $this->data['event_type'] . ',';
                else {
                    if ($i == 1)
                        $outputString .= '0,' . $this->data['event_type'] . ',';
                    else
                        $outputString .= '0,' . SMART_EVENT_LINK . ',';
                    $linked = ($i != 1);
                }
            }

            # Writing event type, phase, chance, flags and parameters
            if (!$linked)
                $outputString .= $this->data['event_phase'] . ',' . $this->data['event_chance'] . ',' . $this->data['event_flags'] . ',';
            else // Linked events cannot happen on their own, avoid unnecessary checks core-side.
                $outputString .= '0,100,0,';

            #! All EAI actions that have the same event are linked. The first one triggers the second, which triggers the third.
            #! Extra linking, based on parameters sharing between events, should be implemented (See Hogger (#448))
            if ($i == 1) {
                for ($j = 1; $j <= 4; $j++) {
                    if ($j == 2 && ($this->data['event_type'] == SMART_EVENT_SPELLHIT || $this->data['event_type'] == SMART_EVENT_SPELLHIT_TARGET))
                        $outputString .= '0,';
                    else
                        $outputString .= $this->data['event_params'][$j] . ',';
                }
            }
            else
                $outputString .= '0,0,0,0,';

            # Writing action parameters
            $outputString .= $this->data['actions'][$i]['SAIAction'] . ',';

            for ($j = 0; $j < 6; $j++)
                $outputString .= (isset($this->data['actions'][$i]['params'][$j]) ? $this->data['actions'][$i]['params'][$j] : 0) . ',';

            # Writing targets
                $outputString .= $this->data['actions'][$i]['target'] . ',';

            if ($this->data['actions'][$i]['SAIAction'] == SMART_ACTION_SUMMON_CREATURE && $this->data['actions'][$i]['isSpecialHandler'])
            {
                $summonData = $this->data['actions'][$i]['extraData'];
                $outputString .= SMART_TARGET_POSITION . ',0,0,0,';
                $outputString .= $summonData->position_x . ',';
                $outputString .= $summonData->position_y . ',';
                $outputString .= $summonData->position_z . ',';
                $outputString .= $summonData->orientation . ',';
            }
            else
                $outputString .= '0,0,0,0,0,0,0,';

            # Build the comment, and we're done.
            
            $outputString .= '"' . $this->buildComment($action['commentType'], $i) . '"';

            $outputString .= '),' . PHP_EOL;

            $this->_parent->increaseSaiIndex();
        }
        
        $this->_parent->addEventToCache($this->data);

        return $outputString;
    }

    private function buildComment($commentType, $actionIndex)
    {
        $match = array(
            '_npcName_' => $this->_parent->npcName,
            '_eventName_' => Utils::GetEventString($this->data['event_type'], $this->data['event_params'])
        );

        $commentType = str_replace(array_keys($match), array_values($match), $commentType);

        
        if ($this->data['actions'][$actionIndex]['SAIAction'] == SMART_ACTION_TALK) {
            $commentType = str_replace('_lineEntry_', $this->data['actions'][$actionIndex]['params'][0], $commentType);
        }

        // Any DBC-needed data is dumped here
        if (Factory::hasDbcWorker()) {
            // Place event precessors here
            if ($this->data['event_type'] == SMART_EVENT_SPELLHIT || $this->data['event_type'] == SMART_EVENT_SPELLHIT_TARGET) {
                // For some bitch reason, some spellhit events have 0 as the spell hitter
                if ($this->data['event_params'][1] != 0) {
                    $commentType = str_replace(
                        '_spellHitSpellId_',
                        Factory::getSpellNameForLoc($this->data['event_params'][1], 0),
                        $commentType);
                }
                else $commentType = str_replace(' _spellHitSpellId_', '', $commentType);
            }
            
            // Place action processors here
            if ($this->data['actions'][$actionIndex]['SAIAction'] == SMART_ACTION_CAST) {
                $commentType = str_replace(
                    '_castSpellId_',
                    Factory::getSpellNameForLoc($this->data['actions'][$actionIndex]['params'][0], 0),
                    $commentType);
            }
            elseif ($this->data['actions'][$actionIndex]['SAIAction'] == SMART_ACTION_REMOVEAURASFROMSPELL && $this->data['actions'][$actionIndex]['params'][0] != 0) {
                $commentType = str_replace(
                    '_removeAuraSpell_',
                    Factory::getSpellNameForLoc($this->data['actions'][$actionIndex]['params'][0], 0),
                    $commentType);
            }
        }
        else
        {
            if ($this->data['actions'][$actionIndex]['SAIAction'] == SMART_ACTION_CAST)
                $commentType = str_replace('_castSpellId_', $this->data['actions'][$actionIndex]['params'][0] . " (Not found in DBCs!)", $commentType);

            elseif ($this->data['event_type'] == SMART_EVENT_SPELLHIT || $this->data['event_type'] == SMART_EVENT_SPELLHIT_TARGET)
                $commentType = str_replace('_spellHitSpellId_', $this->data['event_params'][1] . " (Not found in DBCs!)", $commentType);

            elseif ($this->data['actions'][$actionIndex]['SAIAction'] == SMART_ACTION_REMOVEAURASFROMSPELL && $this->data['actions'][$actionIndex]['params'][0] != 0)
                $commentType = str_replace('_removeAuraSpell_', $this->data['actions'][$actionIndex]['params'][0] . " (Not found in DBCs!)", $commentType);
        }
        // Some other parsing and fixing may be needed here
        return $commentType;
    }
}

class EAI
{
    public function __construct($pdoObj, $parent) {
        $this->_eaiItem = $pdoObj;
        $this->_parent = $parent;
    }

    public function toSAI() {
        $saiData = array();
        $saiData['entryorguid']  = intval($this->_eaiItem->npcId);
        $saiData['npcName']      = $this->_eaiItem->npcName;
        $saiData['source_type']  = 0;

        $saiData['event_type']   = Utils::convertEventToSAI($this->_eaiItem->event_type);
        $saiData['event_chance'] = intval($this->_eaiItem->event_chance);
        $saiData['event_flags']  = Utils::SAI2EAIFlag($this->_eaiItem->event_flags);
        
        $saiData['event_params'] = Utils::convertParamsToSAI($this->_eaiItem);

        $saiData['actions']      = Utils::buildSAIAction($this->_eaiItem);

        if (!is_array($saiData['actions'])) {
            echo PHP_EOL . 'FATAL ERROR! Utils::buildSAIAction() did NOT return an array... Shutting down the engine, cooling down the nuclear reactor' . PHP_EOL;
            exit(1);
        }

        # Build target data
        $saiData['targetData']   = array(
            'target_type' => SMART_TARGET_NONE,
            'position'    => array(),
            'spawnTimeSecs' => 0
        );

        $saiData['event_phase']  = Utils::generateSAIPhase($this->_eaiItem->event_inverse_phase_mask);

        $saiData['saiEntries'] = 0;
        for ($i = 1; $i < 4; $i++)
            if (isset($saiData['actions'][$i]))
                if (count($saiData['actions'][$i]) != 0)
                    $saiData['saiEntries']++;

        return new SAI($saiData, $this->_parent);
    }
}

class CreatureAiText
{
    public $groupId = -1;
    public $textId  = -1;

    public function __construct($item, $parentNpc) {
        $this->_item     = $item;
        $this->_parent   = $parentNpc;
        $this->_eaiEntry = $item->entry;
    }

    public function isGroupIdSet() { return $this->groupId != -1; }
    public function isTextIdSet()  { return $this->textId != -1; }

    public function setGroupId($groupId) { $this->groupId = $groupId; return $this; }
    public function setTextId($textId)   { $this->textId  = $textId;  return $this; }

    public function isFleeEmote() {
        return ($this->_item->entry == -47);
    }

    public function toCreatureText() {
        // Ignore flee emotes.
        if ($this->isFleeEmote()) {
            $this->_parent->setEmoteWhenFleeing(true);
            return '';
        }

        $output  = '(' . $this->_parent->npcId . ',';
        $output .= $this->groupId . ',';
        $output .= $this->textId . ',';

        $content = addslashes($this->_item->content_default);

        $output .= ' "' . str_replace("\'", "'", $content) . '",';
        $output .= $this->typeToSAI($this->_item) . ',';
        $output .= $this->_item->language . ',100,';
        $output .= $this->_item->emote . ',0,';
        $output .= $this->_item->sound . ', "' . addslashes($this->_parent->npcName) . '"),' . PHP_EOL;

        $this->_parent->updateTalkActions($this->_eaiEntry, $this->groupId);

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
