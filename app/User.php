<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;
    protected $table = "users";
    public function plans(){
    	return $this->hasMany('App\Models\Plan','user_id','id');
    }
    public function joins(){
        return $this->belongsToMany('App\Models\Plan','joins','user_id','plan_id');
    }
    public function follows(){
        return $this->belongsToMany('App\Models\Plan','follows','user_id','plan_id')->withPivot('isRequest');
    }
}
