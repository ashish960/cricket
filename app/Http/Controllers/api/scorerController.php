<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\playGame;


use App\Models\User;
use App\Models\Setgame;
use App\Models\Player;
use App\Models\Team;
class scorerController extends Controller
{
    public function playGame(playGame $request){
        $team= Team::where(['game_id'=>$request['game_id']])->where(['team_no'=> $request['team_no']])->first();
        $strikerPlayer= Player::where(['game_id'=>$request['game_id']])->where(['team_no'=>$request['team_no']])->where(['player_status'=>1])->first();
        $nonStrikerPlayer= Player::where(['game_id'=>$request['game_id']])->where(['team_no'=>$request['team_no']])->where(['player_status'=>0])->first();
        
        $nextPlayer= Player::where(['game_id'=>$request['game_id']])->where(['team_no'=>$request['team_no']])->where(['player_status'=>3])->first();
         if($team['team_status'] == '0'){
            return response()->json( [
                'message'=> 'Invalid Request: Give team is balling right now',
                'status'=>0,                     
            ],400);
    }
      else{
           $hit=$request['hit'];
           switch($hit){                                              //for run hitted by the batting team.

          //for 1 run:  
                   case'1' :
                        $current_over_ball=$team['current_over_ball'];
                                          if($current_over_ball == 6){
                                              $team->current_over_ball=1;
                                              $team->team_current_overs+=1;
                                              $team->team_score+=1;
                                              $strikerPlayer->player_status = 0;
                                              $nonStrikerPlayer->player_status=1;
                                              $strikerPlayer->save();
                                              $nonStrikerPlayer->save();
                                              $team->save();
                                          }
                                          else{
                                              $team->current_over_ball+=1;
                                              $team->team_score+=1;
                                              $strikerPlayer->player_status = 0;
                                              $nonStrikerPlayer->player_status=1;
                                              $strikerPlayer->save();
                                              $nonStrikerPlayer->save();
                                              $team->save();   
                                          }
                                          return response()->json([
                                            'message'=>'player_played_successfully',
                                        ],200);
                                        break;
                   
                 //for 2 run:
                    case'2' :
                        $current_over_ball=$team['current_over_ball'];
                                          if($current_over_ball == 6){
                                              $team->current_over_ball=1;
                                              $team->team_current_overs+=1;
                                              $team->team_score+=2;
                                              $team->save();
                                          }
                                          else{
                                              $team->current_over_ball+=1;
                                              $team->team_score+=2;
                                              $team->save();   
                                          }
                                          return response()->json([
                                            'message'=>'player_played_successfully',
                                        ],200);
                                        break;

                    //for 3 run:
                        case'3' :
                            $current_over_ball=$team['current_over_ball'];
                                              if($current_over_ball == 6){
                                                  $team->current_over_ball=1;
                                                  $team->team_current_overs+=1;
                                                  $team->team_score+=3;
                                                  $strikerPlayer->player_status = 0;
                                                  $nonStrikerPlayer->player_status=1;
                                                  $strikerPlayer->save();
                                                  $nonStrikerPlayer->save();
                                                  $team->save();
                                              }
                                              else{
                                                  $team->current_over_ball+=1;
                                                  $strikerPlayer->player_status = 0;
                                                  $nonStrikerPlayer->player_status=1;
                                                  $strikerPlayer->save();
                                                  $nonStrikerPlayer->save();
                                                  $team->team_score+=3;
                                                  $team->save();   
                                              }
                                              return response()->json([
                                                'message'=>'player_played_successfully',
                                            ],200);
                                            break;

                       //for 4 run
                        case'4' :
                            $current_over_ball=$team['current_over_ball'];
                                              if($current_over_ball == 6){
                                                  $team->current_over_ball=1;
                                                  $team->team_current_overs+=1;
                                                  $team->team_score+=4;
                                                  $team->save();
                                              }
                                              else{
                                                  $team->current_over_ball+=1;
                                                  $team->team_score+=4;
                                                  $team->save();   
                                              }
                                              return response()->json([
                                                'message'=>'player_played_successfully',
                                            ],200);
                                            break;   
                                            
                                            
                     
                          //for 6 run:
                        case'6' :
                            $current_over_ball=$team['current_over_ball'];
                                              if($current_over_ball == 6){
                                                  $team->current_over_ball=1;
                                                  $team->team_current_overs+=1;
                                                  $team->team_score+=3;
                                                  $team->save();
                                              }
                                              else{
                                                  $team->current_over_ball+=1;
                                                  $team->team_score+=3;
                                                  $team->save();   
                                              }
                                              return response()->json([
                                                'message'=>'player_played_successfully',
                                            ],200);
                                            break;                  
                                            
                          //for wide
                        case'wide' :
                                                  $team->team_score+=1;
                                                  $team->save();   
                                              return response()->json([
                                                'message'=>'play_again',
                                            ],200);
                                            break;   
                                            
                       //for no ball:
                        case'noball':   
                                             $team->team_score+=1;
                                             $team->save();   
                                         return response()->json([
                                           'message'=>'free-Hit playagain',
                                       ],200);
                                       break; 
                                       
                       case'out':    
                             $strikerPlayer->player_status =2;
                             $nextPlayer->player_status=1;   
                             $strikerPlayer->save();
                             $nextPlayer->save();      
                             return response()->json([
                                'message'=>'player_out,next player on strike',
                            ],200);
                            break;      

           }

      }
}



}
