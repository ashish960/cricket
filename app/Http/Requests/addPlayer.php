<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class addPlayer extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'game_id'=>'required|integer|gt:0|exists:setgames,game_id',
            'player_name'=>'required|string',
            'player_no'=>'required|integer|gt:0',
            'team_no'=>'required|integer|gt:0|exists:teams,team_no'
        ];
    }
    public function messages(){
        return [
           
            'game_id.exists'=>'Invalid Game:There is not such game exists ',
            'team_no.exists'=>'invalid team no'
        ];
    }
}
