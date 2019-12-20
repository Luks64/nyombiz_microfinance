<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    //
    function groups(){
    	return $this->hasMany('App\Group');
    }
}
