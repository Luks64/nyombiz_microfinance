<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    //
    function applicants(){
    	return $this->hasMany('App\Applicant');
    }

    function employee(){
	    return $this->belongsTo('App\Employee');
	}
}
