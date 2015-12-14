<?php

include_once 'model/Player.php';

$rows = ModelPlayer::get(array('order_by' => 'first_name, last_name'));

?>
<h2>Liste des joueurs</h2>

<table>
  <tr>
    <th>N°</th>
    <th>Prénom</th>
    <th>Nom</th>
  </tr>
<?php

foreach($rows as $row)
{
  echo '<tr>
      <td>'.$row['id'].'</td>
      <td>'.$row['first_name'].'</td>
      <td>'.$row['last_name'].'</td>
    </tr>'."\n";
}

?>
</table>