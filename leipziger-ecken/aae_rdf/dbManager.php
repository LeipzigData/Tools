<?php 
  class dbManager{
    public static $db;

    public static function connect($driver, $host, $userId, $password, $database){
      include 'adodb5/adodb.inc.php';
      self::$db=newAdoConnection($driver);
      self::$db->connect($host, $userId, $password, $database);  
      //self::$db->connect('','swp15-aae','visherit','swp15_aae');
      return self::$db;
    }
  
    public static function getConnection(){
      return self::$db;
    }
    
  }
