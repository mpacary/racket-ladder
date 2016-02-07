<?php

include_once 'model/Player.php';

$rows = ModelPlayer::get(array('order_by' => 'first_name, last_name'));

?>
<h2>Liste des joueurs</h2>

<?php

if (count($rows) > 0)
{
  
  ?>

  <table class="table table-hover">
    <thead>
    <tr>
      <!-- <th>ID</th> -->
      <th>Prénom</th>
      <th>Nom</th>
    </tr>
    </thead>
    <tbody>
  <?php

  foreach($rows as $row)
  {
    echo '<tr class="clickable" data-href="'.Routing::getUrlFor(array('module' => $module_code, 'action' => 'detail', 'id' => $row['id'])).'">
        <!-- <td class="text-right">'.$row['id'].'</td> -->
        <td>'.$row['first_name'].'</td>
        <td>'.$row['last_name'].'</td>
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
  <p class="message text-info bg-info">Aucun joueur</p>
  <?php
}