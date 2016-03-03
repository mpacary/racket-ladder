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
    
    if (isset($params['limit']))
      $query .= ' LIMIT '.$params['limit'];
    
    return Database::fetchAll($query);
  }
  
  /**
  * @data array with indexes:
  * - 'id_set_type': integer
  * - 'id_player_1_win': integer
  * - 'id_player_2_win': integer or NULL
  * - 'id_player_1_lose': integer
  * - 'id_player_2_lose': integer or NULL
  * - 'creation_datetime': string at format 'YYYY-MM-DD HH:MM:SS', OPTIONAL
  */  
  static function add($data)
  {
    $id_set_type = $data['id_set_type'];
    $id_player_1_win = $data['id_player_1_win'];
    $id_player_2_win = $data['id_player_2_win'];
    $id_player_1_lose = $data['id_player_1_lose'];
    $id_player_2_lose = $data['id_player_2_lose'];
    
    $init_score_player_1_win = ModelSet::getLatestScore($id_player_1_win, $id_set_type);
    $init_score_player_1_lose = ModelSet::getLatestScore($id_player_1_lose, $id_set_type);

    $init_nb_sets_player_1_win = ModelSet::getNbSets($id_player_1_win, $id_set_type);
    $init_nb_sets_player_1_lose = ModelSet::getNbSets($id_player_1_lose, $id_set_type);

    $new_score_player_1_win = DEFAULT_SCORE;
    $new_score_player_1_lose = DEFAULT_SCORE;


    if (ModelSetType::isDoubles($id_set_type))
    {
      $init_score_player_2_win = ModelSet::getLatestScore($id_player_2_win, $id_set_type);
      $init_score_player_2_lose = ModelSet::getLatestScore($id_player_2_lose, $id_set_type);
      
      $init_nb_sets_player_2_win = ModelSet::getNbSets($id_player_2_win, $id_set_type);
      $init_nb_sets_player_2_lose = ModelSet::getNbSets($id_player_2_lose, $id_set_type);
      
      $new_score_player_2_win = DEFAULT_SCORE;
      $new_score_player_2_lose = DEFAULT_SCORE;
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
    
    $row = array(
        'id_set_type' => $id_set_type,
        'id_player_1_win' => $id_player_1_win,
        'id_player_2_win' => ($id_player_2_win === NULL ? 'NULL' : $id_player_2_win),
        'id_player_1_lose' => $id_player_1_lose,
        'id_player_2_lose' => ($id_player_2_lose === NULL ? 'NULL' : $id_player_2_lose),
        
        'init_score_player_1_win' => $init_score_player_1_win,
        'init_score_player_2_win' => $init_score_player_2_win,
        'init_score_player_1_lose' => $init_score_player_1_lose,
        'init_score_player_2_lose' => $init_score_player_2_lose,

        'init_nb_sets_player_1_win' => $init_nb_sets_player_1_win,
        'init_nb_sets_player_2_win' => $init_nb_sets_player_2_win,
        'init_nb_sets_player_1_lose' => $init_nb_sets_player_1_lose,
        'init_nb_sets_player_2_lose' => $init_nb_sets_player_2_lose,

        'new_score_player_1_win ' => $new_score_player_1_win,
        'new_score_player_2_win ' => $new_score_player_2_win,
        'new_score_player_1_lose' => $new_score_player_1_lose,
        'new_score_player_2_lose' => $new_score_player_2_lose
      );
    
    
    if (isset($data['creation_datetime']))
      $row['creation_datetime'] = "'".Database::escape($data['creation_datetime'])."'";
    

    Database::insert(array(
        'table' => 'bad_set',
        'row' => $row
      ));
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
      return self::getAverageScore($id_set_type);
    
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
      return 1;
    
    return $results[0]['nb_sets'] + 1;
  }
  
  
  static function getAverageScore($id_set_type)
  {
    $rankings = ModelRanking::get($id_set_type);
    
    if (count($rankings) == 0)
      return DEFAULT_SCORE;
    
    $scores = array();
    
    foreach($rankings as $player)
      $scores[] = $player['score'];
    
    return Math::array_average($scores);
  }
}