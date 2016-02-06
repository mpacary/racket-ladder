<?php

include_once 'model/Set.php';
include_once 'model/SetType.php';

$rows = ModelSet::get(array('order_by' => 'creation_datetime desc', 'limit' => 50));

?>

<h2>Liste des sets</h2>

<?php

if (count($rows) > 0)
{
  ?>
  <table class="table table-hover table-bordered">
  <thead>
  <tr>
    <!-- <th>N°</th> -->
    <th>Joué le</th>
    <th>Type</th>
    
    <th colspan="3">Gagnant 1</th>
    <th colspan="3">Gagnant 2</th>
    <th colspan="3">Perdant 1</th>
    <th colspan="3">Perdant 2</th>
    
    <!--
    <th>Nb sets initial G1</th>
    <th>Nb sets initial G2</th>
    <th>Nb sets initial P1</th>
    <th>Nb sets initial P2</th>
    -->
  </tr>
  </thead>
  <tbody>
  <?php

  foreach($rows as $row)
  {
    // compute & format variations
    
    $str_var_w1 = Helper::getHTMLCodeForScoreVariation($row['new_score_player_1_win'], $row['init_score_player_1_win']);
    $str_var_l1 = Helper::getHTMLCodeForScoreVariation($row['new_score_player_1_lose'], $row['init_score_player_1_lose']);
    
    $row['new_score_player_1_win'] = sprintf("%.1f", $row['new_score_player_1_win']);
    $row['new_score_player_1_lose'] = sprintf("%.1f", $row['new_score_player_1_lose']);
    
    if (ModelSetType::isDoubles($row['id_set_type']))
    {
      $str_var_w2 = Helper::getHTMLCodeForScoreVariation($row['new_score_player_2_win'], $row['init_score_player_2_win']);
      $str_var_l2 = Helper::getHTMLCodeForScoreVariation($row['new_score_player_2_lose'], $row['init_score_player_2_lose']);
      
      $row['new_score_player_2_win'] = sprintf("%.1f", $row['new_score_player_2_win']);
      $row['new_score_player_2_lose'] = sprintf("%.1f", $row['new_score_player_2_lose']);
    }
    else
    {
      $str_var_w2 = '';
      $str_var_l2 = '';
    }
    
    echo '
      <tr>
        <!-- <td>'.$row['id'].'</td> -->
        <td>'.$row['creation_datetime'].'</td>
        <td class="center">'.$row['st_abbreviation'].'</td>
        
        <td>'.$row['w1_first_name'].' '.$row['w1_last_name'].'</td>
        <td class="right"><strong>'.$row['new_score_player_1_win'].'</strong></td>
        <td class="right">'.$str_var_w1.'</td>
        
        <td>'.$row['w2_first_name'].' '.$row['w2_last_name'].'</td>
        <td class="right"><strong>'.$row['new_score_player_2_win'].'</strong></td>
        <td class="right">'.$str_var_w2.'</td>
        
        <td>'.$row['l1_first_name'].' '.$row['l1_last_name'].'</td>
        <td class="right"><strong>'.$row['new_score_player_1_lose'].'</strong></td>
        <td class="right">'.$str_var_l1.'</td>
        
        <td>'.$row['l2_first_name'].' '.$row['l2_last_name'].'</td>
        <td class="right"><strong>'.$row['new_score_player_2_lose'].'</strong></td>
        <td class="right">'.$str_var_l2.'</td>
      </tr>
      ';
      /*
        <td>'.$row['init_nb_sets_player_1_win'].'</td>
        <td>'.$row['init_nb_sets_player_2_win'].'</td>
        <td>'.$row['init_nb_sets_player_1_lose'].'</td>
        <td>'.$row['init_nb_sets_player_2_lose'].'</td>
        
        <td>'.$row['new_score_player_1_win'].'</td>
        <td>'.$row['new_score_player_2_win'].'</td>
        <td>'.$row['new_score_player_1_lose'].'</td>
        <td>'.$row['new_score_player_2_lose'].'</td>
      */
    }
  ?>
  </tbody>
  </table>
  <?php
}
else
{
  ?><p class="message text-info bg-info">Aucun set n'a été joué.</p>
  <?php
}

