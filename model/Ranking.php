<?php

include_once 'model/Player.php';

class RankingModel
{
  
  static function get($id_set_type)
  {
    $id_set_type = intval($id_set_type);
    
    // retrieve the distinct list of players who have played the asked set type
    
    $ar_id_players = Database::fetchAll(
        'SELECT DISTINCT id_player FROM (
          (SELECT DISTINCT id_player_1_win AS id_player FROM bad_set WHERE id_set_type = '.$id_set_type.')
          UNION
          (SELECT DISTINCT id_player_2_win AS id_player FROM bad_set WHERE id_set_type = '.$id_set_type.')
          UNION
          (SELECT DISTINCT id_player_1_lose AS id_player FROM bad_set WHERE id_set_type = '.$id_set_type.')
          UNION
          (SELECT DISTINCT id_player_2_lose AS id_player FROM bad_set WHERE id_set_type = '.$id_set_type.')
        ) AS t
        WHERE id_player IS NOT NULL'
      );
    
    $count_id_players = count($ar_id_players);
    
    if ($count_id_players == 0) // nobody played a set for the asked set type
      return array();
    
    $ar_count_players = array();
    
    foreach($ar_id_players as $row)
      $ar_count_players[$row['id_player']] = NULL;
    
    $count_scores_retrieved = 0;
    
    $resource = Database::query('SELECT * FROM bad_set WHERE id_set_type = '.$id_set_type.' ORDER BY creation_datetime DESC');
    
    //while($count_scores_retrieved < $count_id_players && $row = Database::fetchAssoc($resource))
    while($row = Database::fetchAssoc($resource))
    {
      self::addScore($ar_count_players, $count_scores_retrieved, array('id_player' => $row['id_player_1_win'], 'score' => $row['new_score_player_1_win']));
      self::addScore($ar_count_players, $count_scores_retrieved, array('id_player' => $row['id_player_2_win'], 'score' => $row['new_score_player_2_win']));
      self::addScore($ar_count_players, $count_scores_retrieved, array('id_player' => $row['id_player_1_lose'], 'score' => $row['new_score_player_1_lose']));
      self::addScore($ar_count_players, $count_scores_retrieved, array('id_player' => $row['id_player_2_lose'], 'score' => $row['new_score_player_2_lose']));
    }
    
    // add player data
    
    $players = ModelPlayer::get();
    $players_indexed_by_id = array();
    
    foreach($players as $player)
      $players_indexed_by_id[$player['id']] = $player;
    
    foreach($ar_count_players as &$count_player)
    {
      $player = $players_indexed_by_id[$count_player['id']];
      $count_player['first_name'] = $player['first_name'];
      $count_player['last_name'] = $player['last_name'];
    }
    
    unset($count_player);
    
    // order $ar_count_players by score desc
    uasort($ar_count_players, array('self', 'sortByScoreDesc'));
    
    return $ar_count_players;
  }
  
  
  protected static function addScore(&$ar_count_players, &$count_scores_retrieved, $ar_data)
  {
    $id_player = $ar_data['id_player'];
    
    if ($id_player == '')
      return;
    
    if ($ar_count_players[$ar_data['id_player']] !== NULL) // we already retrieved the latest score for that player
    {
      $ar_count_players[$ar_data['id_player']]['nb_sets']++;
      return;
    }
    
    $ar_count_players[$ar_data['id_player']] = array('score' => $ar_data['score'], 'id' => $ar_data['id_player'], 'nb_sets' => 1);
    $count_scores_retrieved++;
  }
  
  
  protected static function sortByScoreDesc($a, $b)
  {
    if ($a['score'] == $b['score'])
      return 0;
    
    return ($a['score'] < $b['score']) ? 1 : -1;
  }
}