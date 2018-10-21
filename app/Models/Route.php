<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Route extends Model
{
	protected $fillable = [ 'plan_id', 'no', 'start_latitude', 'start_longitude', 'starting_time', 'finish_latitude', 'finish_longitude', 'finish_time', 'vehicle', 'activities'];
    public function plan(){
    	return $this->belongsTo('App\Models\Plan','id','plan_id');
    }
}
