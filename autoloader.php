<?php

function __autoload($name) {
  
  if (substr($name, 0, 5) === 'Model')
  {
    $file_to_include = DIR_MODEL.'/'.substr($name, 5).'.php';
  }
  else if (substr($name, 0, 9) === 'Exception')
  {
    $file_to_include = DIR_LIB.'/Exceptions.php';
  }
  else
  {
    $file_to_include = DIR_LIB.'/'.$name.'.php';
  }
  
  if (!file_exists($file_to_include))
  {
    $msg = "Could not load file '".$file_to_include."'.";
    
    // PHPUnit does not supports that the autoloader throws exceptions, see https://github.com/sebastianbergmann/phpunit/issues/1598
    if (defined('PHPUNIT_TESTING'))
    {
      echo "Autoloader error: ".$msg."\n";
      return false;
    }
    else
    {
      throw new Exception($msg);
    }
  }
  
  include_once $file_to_include;
}