<?php

class Factory
{
    private static $dbcWorker;
    
    private function __construct() { }
    
    public static function createOrGetDBCWorker() {
        if (!isset(self::$dbcWorker))
            self::$dbcWorker = new DBC('./dep/dbcs/Spell.dbc', DBCMap::fromINI('./dep/maps/Spell.ini'));
        
        return self::$dbcWorker;
    }
};