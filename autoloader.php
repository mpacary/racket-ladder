<?php

spl_autoload_register(function ($name) {
  
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
  
  if (file_exists($file_to_include))
    include_once $file_to_include;
  
});
