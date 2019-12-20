<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Events\UpdatingPenalty;

class Loan extends Model
{
    // protected $dispatchesEvents = [
    //     'retrieved' => UpdatingPenalty::class,
    // ];  

    // static::created(function($loan) {
    //     Event::fire('penalty.retrieved', $loan);
    // });

    //
    function applicant(){
    	return $this->belongsTo('App\Applicant');
    }

    function LoanRepayment(){
    	return $this->hasMany('App\LoanRepayment');
    }

    function transactions(){
    	return $this->hasMany('App\Transaction');
    }
     
}
