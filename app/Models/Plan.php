<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    //
    protected $table = "plans";
    protected $fillable = ['user_id', 'title', 'start_at', 'end_at', 'cover', 'member', 'description', 'status'];
    public function comments(){
    	return $this->hasMany('App\Models\Comment','plan_id','id');
    }
    // người len kế hoạch
    public function owner() {
    	return $this->hasOne('App\User','id','user_id');
    }
    public function routes(){
    	return $this->hasMany('App\Models\Route','plan_id','id');
    }
    public function joiners(){
    	return $this->belongsToMany('App\User','joins','plan_id','user_id');
    }
    public function followers(){
    	return $this->belongsToMany('App\User','follows','plan_id','user_id')->withPivot('isRequest');
    }

    public function countFollowJoinComment(){
        $this->num_join = $this->joiners->count();
        $this->num_comment = $this->comments->count();
        $this->num_follow = $this->followers->count();
        return $this;
    }

    public function getStatus(){
        $status = $this->getAttribute('status');
        $end = $this->getAttribute('end_at');
        if ( $status === 1){
            $this->state = 1;
        }elseif ($status === 2) {
            if(strtotime($end)<= now()->timestamp){
                $this->state = 3;
            }else{
                $this->state = 2;
            }
        }elseif ($status === 4) {
            $this->state = 4;
        }
        return $this;
    }

}
