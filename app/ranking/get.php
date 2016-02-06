<?php

include_once 'model/Ranking.php';

$rows = RankingModel::get($g_set_type);

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

  $rank = 1;
  $fair_rank = 1;
  $previous_score = NULL;

  foreach($rows as $row)
  {
    if ($previous_score != $row['score'])
      $fair_rank = $rank;
    
    echo '<tr>
        <td class="center">'.$fair_rank.'</td>
        <td>'.$row['first_name'].' '.$row['last_name'].'</td>
        <td class="right">'.sprintf("%.1f", $row['score']).' pts</td>
        <td class="right">'.$row['nb_sets'].'</td>
      </tr>'."\n";
    
    $rank++;
    
    $previous_score = $row['score'];
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