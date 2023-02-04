<?php

namespace App;
use Illuminate\Database\Eloquent\Model;

class Match extends Model
{
	protected $table = 'match';
    protected $fillable = [
        'match_name','match_date','match_id','score-url','tv','bookmaker','fancy','inplay','sports_id','event_id','is_draw','leage_name',
    ];
}
