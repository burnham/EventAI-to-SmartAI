<?php
require_once('./dep/lib/bootstrap.php');
class Factory
{
    private static $dbcWorker;
    private static $dbHandler;

    private static $hostName = 'localhost';
    private static $username = 'root';
    private static $password = '';
    private static $dbName   = '335_world';
    
    private static $_isDbcOn = true;

    private function __construct() { }

    public static function createOrGetDBCWorker() {
        if (!self::$_isDbcOn)
            return null;
    
        if (!isset(self::$dbcWorker))
            self::$dbcWorker = new DBC('./dep/dbcs/Spell.dbc', DBCMap::fromINI('./dep/maps/Spell.ini'));
        
        return self::$dbcWorker;
    }

    public static function createOrGetDBHandler() {
        if (!isset(self::$dbHandler)) {
            $pdoOptions[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
            self::$dbHandler = new PDO('mysql:host=' . self::$hostName . ';dbname=' . self::$dbName, self::$username, self::$password, $pdoOptions);
        }
        return self::$dbHandler;
    }

    public static function setDbData($host, $nick, $pass, $database) {
        self::$hostName = $host;
        self::$username = $nick;
        self::$password = $pass;
        self::$dbName   = $database;
    }
    
    public static function getSpellNameForLoc($spellId, $locIndex) {
        if (!self::$_isDbcOn)
            return $spellId;
        return self::$dbcWorker->getRecordById($spellId)->get('SpellNameLang' . $locIndex, DBC::STRING);
    }
    
    public static function toggleDbcWorker($apply) { self::$_isDbcOn = $apply; }
    public static function hasDbcWorker() { return self::$dbcWorker !== null; }
};
