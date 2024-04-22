<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;


class Setgame extends Model
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'game_id',
        'game_name',
        'no_of_teams',
        'no_of_overs',
        'no_of_players'
    ];
}
