<?php

class Cookie
{
  static function get($var_name, $default_value = NULL)
  {
    return Cookie::exists($var_name) ? $_COOKIE[$var_name] : $default_value;
  }
  
  static function exists($var_name)
  {
    return isset($_COOKIE[$var_name]);
  }
  
  static function set($var_name, $value)
  {
    setcookie($var_name, $value);
  }
  
  static function delete($var_name)
  {
    setcookie($var_name, '', time() - 3600);
  }
}