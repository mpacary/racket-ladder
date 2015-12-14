<?php

class ModelSet
{
  static function get($params)
  {
    $query = 'SELECT s.*,
        w1.first_name as w1_first_name,
        w1.last_name as w1_last_name,
        w2.first_name as w2_first_name,
        w2.last_name as w2_last_name,
        l1.first_name as l1_first_name,
        l1.last_name as l1_last_name,
        l2.first_name as l2_first_name,
        l2.last_name as l2_last_name,
        st.name as st_name,
        st.abbreviation as st_abbreviation
      FROM bad_set s
        LEFT JOIN bad_player AS w1 ON s.id_player_1_win = w1.id
        LEFT JOIN bad_player AS w2 ON s.id_player_2_win = w2.id
        LEFT JOIN bad_player AS l1 ON s.id_player_1_lose = l1.id
        LEFT JOIN bad_player AS l2 ON s.id_player_2_lose = l2.id
        LEFT JOIN bad_set_type AS st ON s.id_set_type = st.id
        ';
    
    if (isset($params['order_by']))
      $query .= ' ORDER BY '.$params['order_by'];
    
    return Database::fetchAll($query);
  }
  
  static function getLatestScore($id_player, $id_set_type)
  {
    $id_player = intval($id_player);
    $id_set_type = intval($id_set_type);
    
    $results = Database::fetchAll('
        (SELECT new_score_player_1_win AS latest_score, creation_datetime
        FROM bad_set
        WHERE id_player_1_win = '.$id_player.' AND id_set_type = '.$id_set_type.'
        ORDER BY creation_datetime DESC
        LIMIT 1)
      UNION ALL
        (SELECT new_score_player_2_win AS latest_score, creation_datetime
        FROM bad_set
        WHERE id_player_2_win = '.$id_player.' AND id_set_type = '.$id_set_type.'
        ORDER BY creation_datetime DESC
        LIMIT 1)
      UNION ALL
        (SELECT new_score_player_1_lose AS latest_score, creation_datetime
        FROM bad_set
        WHERE id_player_1_lose = '.$id_player.' AND id_set_type = '.$id_set_type.'
        ORDER BY creation_datetime DESC
        LIMIT 1)
      UNION ALL
        (SELECT new_score_player_2_lose AS latest_score, creation_datetime
        FROM bad_set
        WHERE id_player_2_lose = '.$id_player.' AND id_set_type = '.$id_set_type.'
        ORDER BY creation_datetime DESC
        LIMIT 1)
      ORDER BY creation_datetime DESC
      LIMIT 1');
      
    if (count($results) == 0)
      return 0;
      
    return $results[0]['latest_score'];
  }
  
  static function getNbSets($id_player, $id_set_type)
  {
    $id_player = intval($id_player);
    $id_set_type = intval($id_set_type);
    
    $results = Database::fetchAll('
      SELECT SUM(nb_sets) AS nb_sets FROM (
        (SELECT COUNT(*) AS nb_sets
        FROM bad_set
        WHERE id_player_1_win = '.$id_player.' AND id_set_type = '.$id_set_type.')
      UNION ALL
        (SELECT COUNT(*) AS nb_sets
        FROM bad_set
        WHERE id_player_2_win = '.$id_player.' AND id_set_type = '.$id_set_type.')
      UNION ALL
        (SELECT COUNT(*) AS nb_sets
        FROM bad_set
        WHERE id_player_1_lose = '.$id_player.' AND id_set_type = '.$id_set_type.')
      UNION ALL
        (SELECT COUNT(*) AS nb_sets
        FROM bad_set
        WHERE id_player_2_lose = '.$id_player.' AND id_set_type = '.$id_set_type.')
      ) AS t
      '
      );
      
    if (count($results) == 0)
      return 0;
    
    return $results[0]['nb_sets'];
  }
}