<?php

$rows = ModelRanking::get($g_set_type);

?>
<h3>Classement : <?php echo $g_ranking_title ?></h3>

<?php

if (count($rows) > 0)
{
  ?>
    
  <table class="table table-hover">
    <thead>
    <tr>
      <th>N°</th>
      <th></th>
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
        <td class="center">'.$row['approved_rank'].'</td>
        <td class="vert-align">'.
          ($row['fair_rank_diff'] > 0 ? '<span class="glyphicon glyphicon-chevron-up positive" aria-hidden="true"></span>' : '')
          .($row['fair_rank_diff'] < 0 ? '<span class="glyphicon glyphicon-chevron-down negative" aria-hidden="true"></span>' : '')
        .'</td>
        <td>'.$row['first_name'].' '.$row['last_name'].'</td>
        <td class="right">'.number_format($row['score'], 1).' pts</td>
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