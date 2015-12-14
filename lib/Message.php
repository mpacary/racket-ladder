<?php

class Message
{
  /*
  * @param $params associative array with indexes 'type' (success, info, warning, error) and 'text'
  */
  static function add($params)
  {
    $messages = self::getAll();
    $messages[] = $params;
    Session::set('messages', $messages);
  }
  
  static function getAll()
  {
    return Session::get('messages', array());
  }
  
  static function clear()
  {
    Session::delete('messages');
  }
}