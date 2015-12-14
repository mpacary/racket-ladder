<?php

class String
{
  function nullify($str)
  {
    return ($str === '' ? 'NULL' : $str);
  }
}