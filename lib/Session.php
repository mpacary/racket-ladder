<?php

class Session
{
  static function start()
  {
    session_start();
  }
  
  static function get($var_name, $default_value = NULL)
  {
    return Session::exists($var_name) ? $_SESSION[$var_name] : $default_value;
  }
  
  static function exists($var_name)
  {
    return isset($_SESSION[$var_name]);
  }
  
  static function set($var_name, $value)
  {
    $_SESSION[$var_name] = $value;
  }
  
  static function delete($var_name)
  {
    if (Session::exists($var_name))
      unset($_SESSION[$var_name]);
  }
}