<?php

namespace App;
use Illuminate\Database\Eloquent\Model;

class Website extends Model
{
    protected $fillable = [
        'title','domain','status','favicon','logo','login_image'
    ];
}
