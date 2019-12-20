<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LoanRepayment extends Model{
    //
    function loan(){
    	return $this->belongsTo('App\Loan');    
    }
}
