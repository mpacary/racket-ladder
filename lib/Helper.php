<?php

/*
* Functions helping to avoid code duplication in views
*/

class Helper
{
  /*
  * @param $params associative array with indexes 'name' (string)
  *                            and 'options' (associative array with option value => option text)
  */
  static function buildSelect($params)
  {
    $str = '<select name="'.$params['name'].'" class="form-control">'."\n";
    
    foreach($params['options'] as $key => $value)
      $str .= '<option value="'.htmlspecialchars($key).'">'.$value.'</option>'."\n";
    
    $str .= '</select>'."\n";
    
    echo $str;
  }
  
  
  static function getHTMLCodeForScoreVariation($new_score, $old_score)
  {
    $is_positive = ($new_score > $old_score);
    $is_negative = ($old_score > $new_score);
    
    $css_class_prefix = 'neutral';
    
    if ($is_positive)
      $css_class_prefix = 'positive';
    else if ($is_negative)
      $css_class_prefix = 'negative';
    
    return '<span class="'.($css_class_prefix).'_score_variation">('.($is_negative ? '' : '+').number_format($new_score - $old_score, 1).')</span>';
  }
}