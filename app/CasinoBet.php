<?php

namespace App;
use Illuminate\Database\Eloquent\Model;

class CasinoBet extends Model
{
	protected $table = 'casino_bet';
    protected $fillable = [
        'user_id','casino_name','team_name','odds_value','stake_value','casino_profit','result_declare','roundid',
    ];
}