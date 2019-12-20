<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Applicant extends Model
{
    //
    function loans(){
    	return $this->hasMany('App\Loan');
    }

	function group(){
	    return $this->belongsTo('App\Group');
	}
}
