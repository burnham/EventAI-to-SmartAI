<?php
class SAI
{
    public function __construct($npcName, $npcId) {
        $this->_npcId   = $npcId;
        $this->_npcName = $npcName;
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