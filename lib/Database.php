<?php

/*
* MP 2015-11-28 PDO actuellement non disponible sur 'Free Pages Perso' (espoir, c'est en train de changer).
* Donc pour le moment je mets des appels aux fonctions "MySQL standard" ici,
* qui pourront être changées par la suite.
*/

class Database
{
  static function open()
  {
    $db_connection = mysql_connect(DB_HOST, DB_LOGIN, DB_PASSWORD);
    
    if ($db_connection === FALSE)
      throw new Exception("Could not connect to database. Error: ".mysql_error());
    
    $db_select_result = mysql_select_db(DB_NAME);
    
    if ($db_connection === FALSE)
      throw new Exception("Could not select database '".DB_NAME."'. Error: ".mysql_error());
      
    Database::query("SET NAMES utf8");
  }
  
  static function close()
  {
    mysql_close();
  }
  
  static function query($str)
  {
    $result = mysql_query($str);

    if ($result === FALSE)
      throw new Exception("Database error for query '".$str."': ".mysql_error());
    
    return $result;
  }
  
  static function fetchAssoc($resource)
  {
    return mysql_fetch_assoc($resource);
  }
  
  static function fetchAll($query)
  {
    $res = Database::query($query);
    
    $result = array();
    
    while($row = Database::fetchAssoc($res))
      $result[] = $row;
    
    return $result;
  }
  
  
  /*
  * @params associative array with indexes 'table' and 'row' (associative array field name => field value)
  */
  static function insert($params)
  {
    $ar_fields = array_keys($params['row']);
    $ar_values = array_values($params['row']);
    
    $str_fields = implode(", ", $ar_fields);
    $str_values = implode(", ", $ar_values);
    
    $query = "INSERT INTO ".$params['table']." (".$str_fields.") VALUES (".$str_values.");";
    
    Database::query($query);
  }
  
  static function escape($str)
  {
    return mysql_real_escape_string($str);
  }
  
}