<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
	protected $table="images";
    public $timestamp = false;
    public function comment(){
    	return $this->belongsTo('App\Models\Comment','id','comment_id');
    }
}
