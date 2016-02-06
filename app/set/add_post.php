<?php

$id_set_type = intval($_POST['id_set_type']);

$id_player_1_win = intval($_POST['id_player_1_win']);
$id_player_2_win = ($_POST['id_player_2_win'] != '' ? intval($_POST['id_player_2_win']) : 'NULL');
$id_player_1_lose = intval($_POST['id_player_1_lose']);
$id_player_2_lose = ($_POST['id_player_2_lose'] != '' ? intval($_POST['id_player_2_lose']) : 'NULL');

$init_score_player_1_win = ModelSet::getLatestScore($id_player_1_win, $id_set_type);
$init_score_player_1_lose = ModelSet::getLatestScore($id_player_1_lose, $id_set_type);

$init_nb_sets_player_1_win = ModelSet::getNbSets($id_player_1_win, $id_set_type);
$init_nb_sets_player_1_lose = ModelSet::getNbSets($id_player_1_lose, $id_set_type);

$new_score_player_1_win = 0;
$new_score_player_1_lose = 0;


if (ModelSetType::isDoubles($id_set_type))
{
  $init_score_player_2_win = ModelSet::getLatestScore($id_player_2_win, $id_set_type);
  $init_score_player_2_lose = ModelSet::getLatestScore($id_player_2_lose, $id_set_type);
  
  $init_nb_sets_player_2_win = ModelSet::getNbSets($id_player_2_win, $id_set_type);
  $init_nb_sets_player_2_lose = ModelSet::getNbSets($id_player_2_lose, $id_set_type);
  
  $new_score_player_2_win = 0;
  $new_score_player_2_lose = 0;
}
else
{
  // set scoring data for doubles to NULL
      
  $init_score_player_2_win = 'NULL';
  $init_score_player_2_lose = 'NULL';
  
  $init_nb_sets_player_2_win = 'NULL';
  $init_nb_sets_player_2_lose = 'NULL';
  
  $new_score_player_2_win = 'NULL';
  $new_score_player_2_lose = 'NULL';
}


Scoring::computeNewScores(
    $id_set_type,
    
    $init_score_player_1_win,
    $init_score_player_2_win,
    $init_score_player_1_lose,
    $init_score_player_2_lose,
    
    $init_nb_sets_player_1_win,
    $init_nb_sets_player_2_win,
    $init_nb_sets_player_1_lose,
    $init_nb_sets_player_2_lose,
    
    $new_score_player_1_win,
    $new_score_player_2_win,
    $new_score_player_1_lose,
    $new_score_player_2_lose
  );


Database::insert(array(
    'table' => 'bad_set',
    'row' => array(
        'id_set_type' => $id_set_type,
        'id_player_1_win' => $id_player_1_win,
        'id_player_2_win' => $id_player_2_win,
        'id_player_1_lose' => $id_player_1_lose,
        'id_player_2_lose' => $id_player_2_lose,
        
        'init_score_player_1_win' => $init_score_player_1_win,
        'init_score_player_2_win' => $init_score_player_2_win,
        'init_score_player_1_lose' => $init_score_player_1_lose,
        'init_score_player_2_lose' => $init_score_player_2_lose,

        'init_nb_sets_player_1_win' => $init_nb_sets_player_1_win,
        'init_nb_sets_player_2_win' => $init_nb_sets_player_2_win,
        'init_nb_sets_player_1_lose' => $init_nb_sets_player_1_lose,
        'init_nb_sets_player_2_lose' => $init_nb_sets_player_2_lose,

        'new_score_player_1_win	' => $new_score_player_1_win,
        'new_score_player_2_win	' => $new_score_player_2_win,
        'new_score_player_1_lose' => $new_score_player_1_lose,
        'new_score_player_2_lose' => $new_score_player_2_lose
      )
  ));

Message::add(array('type' => 'success', 'text' => 'Set ajouté avec succès.'));

Routing::redirect(array('module' => $g_current_module, 'action' => $g_current_action));