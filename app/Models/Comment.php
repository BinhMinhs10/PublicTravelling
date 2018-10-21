<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    //
    protected $table="comments";
    public $timestamp = false;
    public function children() {
    	return $this->hasMany('App\Models\Comment','parent_comment_id','id');
    }
    public function parent(){
    	return $this->belongsTo('App\Models\Comment','id','parent_comment_id');
    }
    public function plan(){
    	return $this->hasOne('App\Models\Plan','id','plan_id');
    }
    public function user() {
    	return $this->hasOne('App\User','id','user_id');
    }
    public function images() {
    	return $this->hasMany('App\Models\Image', 'comment_id', 'id');
    }
}
