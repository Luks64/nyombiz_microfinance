<?php

namespace App\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

use App\Events\LoanInArrears;
use Carbon\Carbon;

class CalculatePenaltyEachDay
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  LoanInArrears  $event
     * @return void
     */
    public function handle(LoanInArrears $event){
        //
        $now = Carbon::now();

        if($now->diffInDays($event->loan->date_of_completion) > 0){

            $days_in_arrears = $now->diffInDays($event->loan->date_of_completion);

            $total_penalty = 0;

            $balance_to_penalize = $event->loan->due_loan;

            for($i = 1; $i <= $days_in_arrears; $i++){

                $penalty = (5/100)*$balance_to_penalize;

                $balance_to_penalize = $balance_to_penalize + $penalty;
                $total_penalty = $total_penalty + $penalty;
            }

            $event->loan->penalty = $total_penalty;
            $event->loan->save();
        }
    }
}
