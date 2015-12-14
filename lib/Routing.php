<?php

class Routing
{

  /*
  * @params associative array of URL parameters
  */
  static function getUrlFor($params)
  {
    $strparams = '';
    
    if (is_array($params) && count($params) > 0)
      $strparams = '?'.http_build_query($params);
     
    return 'http://'.$_SERVER["SERVER_NAME"].strtok($_SERVER["REQUEST_URI"],'?').$strparams;
  }
  
  static function redirect($params)
  {
    header('Location: '.self::getUrlFor($params));
  }

}