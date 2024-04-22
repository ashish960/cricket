<?php

namespace App\Http\Controllers\api;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\adminLogin;
use App\Http\Requests\setGames;
use App\Http\Requests\addPlayer;
use App\Http\Requests\addTeam;
use App\Http\Requests\startGame;


use App\Models\User;
use App\Models\Setgame;
use App\Models\Player;
use App\Models\Team;

class AdminController extends Controller
{

    //adminlogin
   
    public function adminLogin(adminLogin $request){
        
        $user =User::where(['email'=>$request['email'],'password' => $request['password']])->first();
        $token = $user->createToken("auth_token",["Admin"])->accessToken;  //here admin is the scope of token 
        return response()->json(
            [
                'token' => $token,
                'user' => $user,
                'message' => 'Login successfully',
                'status' =>1
            ],200
            );
   }


   //adminSetGame
   public function SetGame(setGames $request){
    $gameSet=[
           'game_id'=>$request->game_id,
           'game_name'=>$request->game_name,
           'no_of_teams'=>$request->no_of_teams,
           'no_of_players'=>$request->no_of_players,
           'no_of_overs'=>$request->no_of_overs
    ];
    try{
        Setgame::create($gameSet);  
    }catch(\Exception $err){
        
        $gameSet=null;
    }
    if($gameSet != null){
        return response()->json([
            'message'=>'Game Created  Successfully',
            'status' =>1
        ],200);
    }
    else{
         return response()->json([
            'message'=>'Internal Server Error',
             'error_msg'=>$err->getMessage()
         ],500);
    }  
}


//Admin set Team
public function AddTeam(addTeam $request){
    $game=Setgame::where(['game_id'=>$request['game_id']])->first();
    $team =Team::where(['game_id'=>$request['game_id']])->where(['team_no'=> $request['team_no']])->first();
    if($team==null){
        if($request['team_no'] <= $game['no_of_teams']){
            $data=[
                'game_id'=>$request->game_id,
                'team_name' =>$request->team_name,
                'team_no' =>$request->team_no
              ];          
          try{
              Team::create($data);   
          }catch(\Exception $err){
              $data=null;
          }
          if($data != null){
                    return response()->json([
                        'message' => 'Team Register successfully',
                        'status' =>1
                    ],200);}
                    else{
                        return response()->json([
                            'message' => 'Internal server error',
                            'error_msg'=>$err->getMessage(),
                            'status' =>0
                        ],500);
                  }       
        }
        else{
            return response()->json([
                'message' => 'Team No Exceeds Beyond the Team limit for the game the Team no should be between 1 to '.$game['no_of_teams'] ,
                'status' =>0
            ],400);
        }   
    }
    else{
            return response()->json([
                'message' => 'The given Team no is already exists',
            ],400);
        }  
    }



//Admin set Player
public function AddPlayer(addPlayer $request){
    $game=Setgame::where(['game_id'=>$request['game_id']])->first();
    $player= Player::where(['game_id'=>$request['game_id']])->where(['player_no'=> $request['player_no']])->where(['team_no'=>$request['team_no']])->first();
    if($player == null){
    if($request['player_no'] <= $game['no_of_players']){
            $data=[
                'player_name' =>$request->player_name,
                'player_no' =>$request->player_no,
                'team_no'=>$request->team_no,
                'game_id'=>$request->game_id
              ];      
          try{
              Player::create($data);   
          }catch(\Exception $err){
             
              $data=null;
          }
          if($data != null){
            return response()->json([
                'message' => 'Player Register successfully',
                'status' =>1
            ],200);}
            else{
                return response()->json([
                    'message' => 'Internal server error',
                    'status'=>0
                ],500);
            }     
    }
    else{
        return response()->json([
            'message' => 'Player No Exceeds Beyond the Player limit for the game the player no should be between 1 to '.$game['no_of_players'] ,
            'status'=>0
        ],400);
    }   
}
else{
    return response()->json([
        'message' => 'The given player no is already exists',
        'status'=>0
    ],400);
}  
        }

    

//admin start game

   public function StartGame(startGame $request){
    try{
        $updateTeamStatus =Team::where(['game_id'=>$request['game_id']])->where(['team_no'=> 1])->first();
        $updateTeamStatus->team_status =1;
        $updatePlayerStatus =Player::where(['game_id'=>$request['game_id']])->where(['team_no'=> 1])->where(['player_no'=> 1])->first();  
        $updatePlayerStatus->player_status =1;
        $updateTeam =  Team::where(['game_id'=>$request['game_id']])->where('team_no', '!=', 1)->get();
        $updateTeam->team_status =0;
        $updatePlayer =  Player::where(['game_id'=>$request['game_id']])->where(['team_no'=> 1])->where('player_no', '!=', 1)->get();
        $updatePlayer->player_status =0;
        $updatePlayer2 =  Player::where(['game_id'=>$request['game_id']])->where(['team_no'=> 2])->where('player_no', '!=', 1)->get();
        $updatePlayer2->player_status=0;


         $updateTeamStatus->save();
         $updatePlayerStatus->save();
         $updateTeam->save();
         $updatePlayer->save();
         $updatePlayer2->save();

      }catch(\Exception $err){
            $updateTeamStatus=null;
            $updatePlayerStatus= null;
            $updatePlayer =null;
            $updateTeam= null;
            $updatePlayer2=null;
    }
    if($updateTeamStatus == null && $updatePlayerStatus == null &&  $updatePlayer &&  $updateTeam  && $updatePlayer2 ){
        return response()->json([
            'status' => 0,
            'message'=> 'Internal Server Error'
        ],500); 
    }else{

  return response()->json([
      'status' => 1,
      'message'=> 'Game Started'
  ],200);                    
}
}        


}
