<?php

class ModelPlayer
{
  static function get($params = array())
  {
    $query = 'SELECT * FROM bad_player';
    
    if (isset($params['order_by']))
      $query .= ' ORDER BY '.$params['order_by'];
    
    return Database::fetchAll($query);
  }
  
  static function getById($id)
  {
    $query = 'SELECT *
      FROM bad_player
      WHERE id = '.intval($id);
      
    return Database::fetchOne($query);
  }
}