<?php

include_once 'model/Ranking.php';

$rows = RankingModel::get($g_set_type);

?>
<h2>Classement : <?php echo $g_ranking_title ?></h2>

<table>
  <tr>
    <th>N°</th>
    <th>Nom</th>
    <th>Score</th>
  </tr>
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
      <td class="right">'.$row['score'].' pts</td>
    </tr>'."\n";
  
  $rank++;
  
  $previous_score = $row['score'];
}

?>
</table>