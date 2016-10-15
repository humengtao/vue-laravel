<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    function comment()
    {
        return $this->hasMany('App\Models\Comment');
    }

    public function records(){
        return $this->hasMany('App\Models\Records');
    }

    public function user(){
        return $this->belongsTo('App\User','user_id','id');
    }
}
