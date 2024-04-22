<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Team;
use App\Http\Requests\viewScore;
class viewerController extends Controller
{
    public function viewScore(viewScore $request){
        //to view current playing team score.
        $team= Team::where(['game_id'=>$request['game_id']])->where(['team_no'=> $request['team_no']])->first();
        if($team['team_status' == 0]){
            return response()->json( [
                'message'=> 'Invalid Request: Give team is balling right now',
                'status'=>0,                     
            ],400);
        }
        else{
            return response()->json( [
                'team_score'=> $team['team_score'],
                'status'=>1,                     
            ],200);
        }
    }
}
