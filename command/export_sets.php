<?php

include 'bootstrap.php';

Database::open();

$sets = ModelSet::get(array('order_by' => 'creation_datetime'));

Database::close();

foreach($sets as $set)
{
  echo "ModelSet::add(array(
      'creation_datetime' => '".$set['creation_datetime']."',
      'id_set_type' => ".$set['id_set_type'].",
      'id_player_1_win' => ".$set['id_player_1_win'].",
      'id_player_2_win' => ".($set['id_player_2_win'] === NULL ? "'NULL'" : $set['id_player_2_win']).",
      'id_player_1_lose' => ".$set['id_player_1_lose'].",
      'id_player_2_lose' => ".($set['id_player_2_lose'] === NULL ? "'NULL'" : $set['id_player_2_lose'])."
    ));";
  echo "\n";
}