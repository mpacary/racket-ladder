<?php

chdir(dirname(__FILE__));
chdir('..');

define('PHPUNIT_TESTING', TRUE);

include 'config.php';
include 'constants.php';
include 'autoloader.php';


class ScoringTest extends PHPUnit_Framework_TestCase
{

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
        array(ID_SET_TYPE_MIXED_DOUBLES,   15, 6.67, 0, 8.33,     1, 3, 3, 3,   15, 8.54, 0, 6.46),
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