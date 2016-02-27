<?php

include_once 'model/Ranking.php';

$rows = ModelRanking::get($g_set_type);

?>
<h2>Classement : <?php echo $g_ranking_title ?></h2>

<?php

if (count($rows) > 0)
{
  ?>
    
  <table class="table table-hover">
    <thead>
    <tr>
      <th>N°</th>
      <th>Nom</th>
      <th>Score</th>
      <th>Nb sets</th>
    </tr>
    </thead>
    <tbody>
  <?php
  
  foreach($rows as $row)
  {
    $class_grayed = "";
    
    if ($row['nb_sets'] < MIN_SETS_FOR_BEING_RANKED)
      $class_grayed = "grayed";
    
    echo '<tr class="clickable '.$class_grayed.'" data-href="'.Routing::getUrlFor(array('module' => 'player', 'action' => 'detail', 'id' => $row['id'])).'">
        <td class="center">'.$row['fair_rank'].'</td>
        <td>'.$row['first_name'].' '.$row['last_name'].'</td>
        <td class="right">'.sprintf("%.1f", $row['score']).' pts</td>
        <td class="right">'.$row['nb_sets'].'</td>
      </tr>'."\n";
  }

  ?>
    </tbody>
  </table>
  
  <?php
}
else
{
  ?>
  <p class="message text-info bg-info">Aucun set n'a été joué dans cette catégorie.</p>
  <?php
}