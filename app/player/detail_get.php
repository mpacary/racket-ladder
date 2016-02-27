<?php

$form_url = Routing::getUrlFor(array('module' => $g_current_module, 'action' => $g_current_action));

$player = ModelPlayer::getById($_GET['id']);

$rankings = ModelRanking::getForPlayer($_GET['id']);

?>
<h2><?php echo $player['first_name'].' '.$player['last_name'] ?></h2>

<form class="form-horizontal" action="<?php echo $form_url; ?>" method="post">

  <div class="form-group">
    <label for="first_name" class="col-sm-2 control-label">Prénom</label>
    <div class="col-sm-10">
      <input class="form-control" type="text" name="first_name" value="<?php echo htmlspecialchars($player['first_name']) ?>" />
    </div>
  </div>
  
  <div class="form-group">
    <label for="last_name" class="col-sm-2 control-label">Nom</label>
    <div class="col-sm-10">
      <input class="form-control" type="text" name="last_name" value="<?php echo htmlspecialchars($player['last_name']) ?>" />
    </div>
  </div>
  
  <div class="form-group">
    <label for="last_name" class="col-sm-2 control-label">Classements</label>
    <div class="col-sm-10">
      <?php
        
        if (count($rankings) > 0)
        {
          ?>
          <table class="table table-hover">
          <thead>
            <tr>
              <th>Catégorie</th>
              <th>Position</th>
              <th class="right">Score</th>
              <th class="right">Nb. sets</th>
            </tr>
          </thead>
          <tbody>
          <?php
          foreach($rankings as $ranking)
          {
            $class_grayed = "";
            
            if ($ranking['player_nb_sets'] < MIN_SETS_FOR_BEING_RANKED)
              $class_grayed = "grayed";
            
            ?>
            <tr class="clickable <?php echo $class_grayed ?>"
                data-href="<?php echo Routing::getUrlFor(array('module' => 'ranking', 'action' => $ranking['category_abbreviation'])) ?>">
              <td><?php echo $ranking['category_name'] ?></td>
              <td class="center"><?php echo $ranking['player_fair_rank']." / ".$ranking['total_players'] ?></td>
              <td class="right"><?php echo sprintf("%.1f", $ranking['player_score']) ?> pts</td>
              <td class="right"><?php echo $ranking['player_nb_sets'] ?></td>
            </tr>
            <?php
          }
          ?>
          </tbody>
          </table>
          <?php
        }
        else
        {
          ?>
          <p class="message text-info bg-info">Non classé (pas de set enregistré).</p>
          <?php
        }
      ?>
    </div>
  </div>
  
  <input type="hidden" name="id" value="<?php echo intval($player['id']) ?>" />
  
  <div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
      <input class="btn btn-default" type="submit" value="Enregistrer" />
    </div>
  </div>

</form>
