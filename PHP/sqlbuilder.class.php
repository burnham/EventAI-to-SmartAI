<?php
class SAI
{
    public function __construct() {
    }
}

class EAI
{
    public function __construct($pdoObj) {
        $this->_eaiItem = $pdoObj;
    }
    
    public function toSAI($pdoDriver) {
        $saiData = array();
        $saiData['entryorguid']  = intval($this->_eaiItem->npcId);
        $saiData['source_type']  = 0;
        
        $saiData['event_type']   = Utils::convertEventToSAI($this->_eaiItem->event_type);
        $saiData['event_chance'] = intval($this->_eaiItem->event_chance);
        $saiData['event_flags']  = Utils::SAI2EAIFlag($this->_eaiItem->event_flags);
        
        $saiData['event_params'] = Utils::convertParamsToSAI($this->_eaiItem);
        
        for ($i = 0; $i < 4; $i++)
            $saiData['action' . $i] = Utils::buildSAIAction($this->_eaiItem->{"action".$i."_type"},
                                        $this->_eaiItem->{"action".$i."_param1"}, $this->_eaiItem->{"action".$i."_param2"}, $this->_eaiItem->{"action".$i."_param3"}, $pdoDriver);

        return $saiData;
    }
}

class EAIText
{
    public function __construct($oldIdx, $content, $sound, $type, $lang, $emote, $comment) {
        $this->_item = array(
            'oldEntry' => $oldIdx,
            'content'  => $content,
            'soundId'  => $sound,
            'eaiType'  => $type,
            'emoteId'  => $emote,
            'comment'  => $comment
        );
    }
}

class SAICollection
{
    private $items = array();

    public function getStore() { return $this->items; }

    public function addItem($pdoObj) {
        $this->items[] = new SAI($pdoObj);
    }
}

class EAICollection
{
    private $items = array();

    public function getStore() { return $this->items; }

    public function addItem($pdoObj) {
        $this->items[] = new EAI($pdoObj);
    }
}

class TextsCollection
{
    private $items = array();
    
    public function getStore() { return $this->items; }

    public function addItem($pdoObj) {
        $this->items[] = new CreatureText($pdoObj);
    }
}

class CreatureText
{
    public function __construct($npcEntry, $textId, $groupId, $soundId, $comment, $emoteId, $languageId, $probability, $duration, $type) {
        $this->entry = array(
            'entry'     => $npcEntry,
            'groupid'   => $groupId,
            'id'        => $textId,
            'type'      => $type,
            'language'  => $languageId,
            'probability' => $probability,
            'emote'     => $emoteId,
            'duration'  => $duration,
            'sound'     => $soundId,
            'comment'   => '"' . addslashes($comment) . '"'
        );
        $this->structure = array_keys($this->entry);
    }
    
    public function setText($text) {
        $this->entry['text'] = '"' . addslashes($text) . '"';
        $this->structure = array_keys($this->entry);
    }
    
    public function __toString() {
        return '(' . implode(', ', $this->entry) . '),';
    }
}