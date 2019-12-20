<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    //
    function loan(){
    	return $this->belongsTo('App\Loan');
    }
}
