<?php

class Scoring
{
  
  static function computeNewScores(
      $id_set_type,
    
      $init_score_player_1_win,
      $init_score_player_2_win,
      $init_score_player_1_lose,
      $init_score_player_2_lose,
      
      $init_nb_sets_player_1_win,
      $init_nb_sets_player_2_win,
      $init_nb_sets_player_1_lose,
      $init_nb_sets_player_2_lose,
      
      &$new_score_player_1_win,
      &$new_score_player_2_win,
      &$new_score_player_1_lose,
      &$new_score_player_2_lose
    )
  {
    
    if (ModelSetType::isSingles($id_set_type))
    {
            
      if ($init_score_player_1_win - $init_score_player_1_lose > 10)
      {
        // winner already had a much bigger score than loser => scores unchanged
        $new_score_player_1_win = $init_score_player_1_win;
        $new_score_player_1_lose = $init_score_player_1_lose;
      }
      else
      {
        // new winner score
        
        $nb_sets_for_average = min($init_nb_sets_player_1_win, MAX_SETS_FOR_AVERAGE);
        
        $new_score_player_1_win = ($init_score_player_1_win * $nb_sets_for_average + 10 + $init_score_player_1_lose)
          / ($nb_sets_for_average + 1);
        
        $new_score_player_1_win = max($init_score_player_1_win, $new_score_player_1_win); // only >= 0 variations
        
        // new loser score
        
        $nb_sets_for_average = min($init_nb_sets_player_1_lose, MAX_SETS_FOR_AVERAGE);
        
        $new_score_player_1_lose = ($init_score_player_1_lose * $nb_sets_for_average + max(0, $init_score_player_1_win - 10))
          / ($nb_sets_for_average + 1);
          
        $new_score_player_1_lose = min($init_score_player_1_lose, $new_score_player_1_lose); // only <= 0 variations
      }
    }
    else // process scores for Doubles
    {
      $init_score_winning_team = ($init_score_player_1_win + $init_score_player_2_win) / 2;
      $init_score_losing_team = ($init_score_player_1_lose + $init_score_player_2_lose) / 2;
      
      if ($init_score_winning_team - $init_score_losing_team > 10)
      {
        // winners already had a much bigger score than losers => scores unchanged
        $new_score_player_1_win = $init_score_player_1_win;
        $new_score_player_2_win = $init_score_player_2_win;
        $new_score_player_1_lose = $init_score_player_1_lose;
        $new_score_player_2_lose = $init_score_player_2_lose;
      }
      else
      {
        // new winners scores
        
        $nb_sets_for_average = min($init_nb_sets_player_1_win, MAX_SETS_FOR_AVERAGE);
        
        $new_score_player_1_win = ($init_score_player_1_win * $nb_sets_for_average + 10 + $init_score_losing_team)
          / ($nb_sets_for_average + 1);
        
        $new_score_player_1_win = max($init_score_player_1_win, $new_score_player_1_win); // only >= 0 variations
        
        
        $nb_sets_for_average = min($init_nb_sets_player_2_win, MAX_SETS_FOR_AVERAGE);
        
        $new_score_player_2_win = ($init_score_player_2_win * $nb_sets_for_average + 10 + $init_score_losing_team)
          / ($nb_sets_for_average + 1);
        
        $new_score_player_2_win = max($init_score_player_2_win, $new_score_player_2_win); // only >= 0 variations
        
        // new losers scores
        
        $nb_sets_for_average = min($init_nb_sets_player_1_lose, MAX_SETS_FOR_AVERAGE);
        
        $new_score_player_1_lose = ($init_score_player_1_lose * $nb_sets_for_average + max(0, $init_score_winning_team - 10))
          / ($nb_sets_for_average + 1);
        
        $new_score_player_1_lose = min($init_score_player_1_lose, $new_score_player_1_lose); // only <= 0 variations
        
        
        $nb_sets_for_average = min($init_nb_sets_player_2_lose, MAX_SETS_FOR_AVERAGE);
        
        $new_score_player_2_lose = ($init_score_player_2_lose * $nb_sets_for_average + max(0, $init_score_winning_team - 10))
          / ($nb_sets_for_average + 1);
        
        $new_score_player_2_lose = min($init_score_player_2_lose, $new_score_player_2_lose); // only <= 0 variations
      }
    }
    
  }
  
}