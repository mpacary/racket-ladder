<?php

include 'bootstrap.php';

Database::open();

$sets = ModelSet::get(array('order_by' => 'creation_datetime'));

Database::close();

foreach($sets as $set)
{
  /*["creation_datetime"]=>
  string(19) "2016-02-04 22:52:08"
  ["id_set_type"]=>
  string(1) "4"
  ["id_player_1_win"]=>
  string(2) "19"
  ["id_player_2_win"]=>
  string(2) "16"
  ["id_player_1_lose"]=>
  string(2) "20"
  ["id_player_2_lose"]=>
  string(2) "14"*/
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