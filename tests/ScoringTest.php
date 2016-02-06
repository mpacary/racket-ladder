<?php

chdir(dirname(__FILE__));
chdir('..');

define('PHPUNIT_TESTING', TRUE);

include 'config.php';
include 'constants.php';
include 'autoloader.php';


class ScoringTest extends PHPUnit_Framework_TestCase
{

  /*
  SINGLES
  14  2016-02-06 22:27:48 2 8 NULL  11  NULL  0.00  NULL  0.00  NULL  0 NULL  0 NULL  10.00 NULL  0.00  NULL
  15  2016-02-06 22:27:57 2 11  NULL  13  NULL  0.00  NULL  0.00  NULL  1 NULL  0 NULL  5.00  NULL  0.00  NULL
  17  2016-02-06 22:28:15 2 8 NULL  10  NULL  10.00 NULL  0.00  NULL  1 NULL  1 NULL  10.00 NULL  0.00  NULL
  18  2016-02-06 22:28:21 2 11  NULL  13  NULL  5.00  NULL  5.00  NULL  2 NULL  2 NULL  8.33  NULL  3.33  NULL
    
  DOUBLES
  5 8 11  9 13  0.00  0.00  0.00  0.00  0 0 0 0 10.00 10.00 0.00  0.00
  7 2016-02-06 18:10:42 5 8 13  9 10  10.00 0.00  0.00  0.00  1 1 1 0 10.00 5.00  0.00  0.00
  8 2016-02-06 18:14:40 5 23  13  8 9 0.00  5.00  10.00 0.00  0 2 2 2 15.00 8.33  6.67  0.00
  12  2016-02-06 18:19:33 5 23  8 9 13  15.00 6.67  0.00  8.33  1 3 3 3 14.58 8.54  0.21  6.46 <== WRONG
  13  2016-02-06 18:19:42 5 23  8 9 13  14.58 8.54  0.21  6.46  2 4 4 4 14.17 9.50  0.48  5.48 <== WRONG
  */


  function testProvider()
  {
    return array(
        /* singles: 2x init scores, 2x init nb sets, 2x result scores */
        array(ID_SET_TYPE_MEN_SINGLES,     0, 'NULL', 0, 'NULL',     0, 'NULL', 0, 'NULL',     10, 'NULL', 0, 'NULL'),
        array(ID_SET_TYPE_WOMEN_SINGLES,   0, 'NULL', 0, 'NULL',     1, 'NULL', 0, 'NULL',     5, 'NULL', 0, 'NULL'),
        array(ID_SET_TYPE_MEN_SINGLES,     10, 'NULL', 0, 'NULL',    1, 'NULL', 1, 'NULL',     10, 'NULL', 0, 'NULL'),
        array(ID_SET_TYPE_WOMEN_SINGLES,   5, 'NULL', 5, 'NULL',     2, 'NULL', 2, 'NULL',     8.33, 'NULL', 3.33, 'NULL'),
        
        
        /* doubles: 4x init scores, 4x init nb sets, 4x result scores */
        array(ID_SET_TYPE_MIXED_DOUBLES,   0, 0, 0, 0,            0, 0, 0, 0,   10, 10, 0, 0),
        array(ID_SET_TYPE_MEN_DOUBLES,     10, 0, 0, 0,           1, 1, 1, 0,   10, 5,  0, 0),
        array(ID_SET_TYPE_WOMEN_DOUBLES,   0, 5, 10, 0,           0, 2, 2, 2,   15, 8.33, 6.67, 0),
        array(ID_SET_TYPE_MIXED_DOUBLES,   15, 6.67, 0, 8.33,     1, 3, 3, 3,   14.58, 8.54, 0.21, 6.46),
      );
  }
  
  
  /**
  * @dataProvider testProvider
  */ 
  function test(
      $id_set_type,
      
      $init_score_player_1_win,
      $init_score_player_2_win,
      $init_score_player_1_lose,
      $init_score_player_2_lose,
      
      $init_nb_sets_player_1_win,
      $init_nb_sets_player_2_win,
      $init_nb_sets_player_1_lose,
      $init_nb_sets_player_2_lose,
      
      $expected_new_score_player_1_win,
      $expected_new_score_player_2_win,
      $expected_new_score_player_1_lose,
      $expected_new_score_player_2_lose
    )
  {
    
    $new_score_player_1_win = 0;
    $new_score_player_1_lose = 0;
    
    if (ModelSetType::isSingles($id_set_type))
    {
      $new_score_player_2_win = 'NULL';
      $new_score_player_2_lose = 'NULL';
    }
    else
    {
      $new_score_player_2_win = 0;
      $new_score_player_2_lose = 0;
    }
    
    Scoring::computeNewScores(
                              
      // input params
      
      $id_set_type,
      
      $init_score_player_1_win,
      $init_score_player_2_win,
      $init_score_player_1_lose,
      $init_score_player_2_lose,
      
      $init_nb_sets_player_1_win,
      $init_nb_sets_player_2_win,
      $init_nb_sets_player_1_lose,
      $init_nb_sets_player_2_lose,
      
      // output params
      
      $new_score_player_1_win,
      $new_score_player_2_win,
      $new_score_player_1_lose,
      $new_score_player_2_lose
    );
    
    $this->assertEquals($expected_new_score_player_1_win,  $new_score_player_1_win, '', 0.01);
    $this->assertEquals($expected_new_score_player_2_win,  $new_score_player_2_win, '', 0.01);
    $this->assertEquals($expected_new_score_player_1_lose, $new_score_player_1_lose, '', 0.01);
    $this->assertEquals($expected_new_score_player_2_lose, $new_score_player_2_lose, '', 0.01);
  }
  
  
}