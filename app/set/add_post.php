<?php

$id_set_type = intval($_POST['id_set_type']);

$id_player_1_win = intval($_POST['id_player_1_win']);
$id_player_2_win = ($_POST['id_player_2_win'] != '' ? intval($_POST['id_player_2_win']) : 'NULL');
$id_player_1_lose = intval($_POST['id_player_1_lose']);
$id_player_2_lose = ($_POST['id_player_2_lose'] != '' ? intval($_POST['id_player_2_lose']) : 'NULL');


ModelSet::add(array(
    'id_set_type' => $id_set_type,
    'id_player_1_win' => $id_player_1_win,
    'id_player_2_win' => $id_player_2_win,
    'id_player_1_lose' => $id_player_1_lose,
    'id_player_2_lose' => $id_player_2_lose,
  ));


Message::add(array('type' => 'success', 'text' => 'Set ajouté avec succès.'));

Routing::redirect(array('module' => $g_current_module, 'action' => $g_current_action));