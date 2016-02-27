<?php

class Math
{
  // from https://gist.github.com/ischenkodv/262906/128e5864fb09fee0dbed9cabe09b4537b4b02bbc
  function array_median($arr)
  {
    if (count($arr) == 0)
      throw new Exception('Could not compute median for empty array');
    
    sort($arr, SORT_NUMERIC);
    
    $count = count($arr); // total numbers in array
    $middleval = floor(($count-1)/2); // find the middle value, or the lowest middle value

    if ($count % 2)
    {
      // odd number, middle is the median
      $median = $arr[$middleval];
    }
    else
    {
      // even number, calculate avg of 2 medians
      $low = $arr[$middleval];
      $high = $arr[$middleval+1];
      $median = (($low+$high)/2);
    }
    
    return $median;
  }
  
  // from https://gist.github.com/ischenkodv/262906/128e5864fb09fee0dbed9cabe09b4537b4b02bbc
  function array_average($arr)
  {
    if (count($arr) == 0)
      throw new Exception('Could not compute average value for empty array');
    
    $count = count($arr); // total numbers in array
    
    foreach ($arr as $value)
      $total += $value;
    
    return $total / $count; // get average value
  }
}