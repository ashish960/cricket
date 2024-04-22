<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class setGames extends FormRequest
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
            'game_id'=>'required|integer|unique:setgames,game_id|gt:0',
            'game_name'=>'required|string',
            'no_of_teams'=>'required|integer|gt:1|in:2',
            'no_of_players'=>'required|integer|gt:1',
            'no_of_overs'=>'required|integer|gt:0'

        ];
    }
}
