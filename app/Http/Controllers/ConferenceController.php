<?php

namespace App\Http\Controllers;

use App\Jobs\CancelConference;
use App\Jobs\RefundAttendee;
use App\Models\Conference;
use Illuminate\Http\Request;

class ConferenceController extends Controller
{
    //

    public function sendCancelEmails($id)
    {
        //Making Sure We Have Enough Workers
        //If that job takes 5 hours to finish, the worker processing it will be busy for 5 hours
        // and won't be able to process any other jobs during that time.
        //When we have long-running jobs in place, it's always a good idea to make
        //sure we have enough workers to handle other jobs. However, while having
        //more workers, we could still get into a situation where all workers pick a 5-
        //hour job up.
        //To prevent this, we need to push these long-running jobs to a special queue
        //and assign just enough workers to it. All this while having other workers
        //processing jobs from the main queue.
        //If we dispatch our CancelConference job to a cancelations queue, assign 5
        //workers to that queue, and have another 5 workers processing jobs from
        //the main queue, we'll only have 50% of our workers with a chance to be
        //stuck at long-running jobs.
        $conference = Conference::find($id);
//        CancelConference::dispatch($conference)->onQueue('cancelations');
        //php artisan queue:work --queue=cancelations,default --timeout=18000


//        Instead of dispatching our job to a cancelations queue, we're going to
//dispatch it to the database-cancellations connection:

//        CancelConference::dispatch($conference)->onConnection(
//            'database-cancelations'
//        );
////php artisan queue:work database-cancelations
///
///
///
/// Dispatching Multiple Jobs Instead of One
//Our job may run for as long as 5 hours to refund all the attendees and send
//them an email one by one. While doing so, the worker won't be able to pick
//up any other job since it can only process one job at a time.
//Moreover, if an exception was thrown at any point and the job was retried,
//we will have to start the iteration again and make sure we skip refunding
//invoices that were already refunded.
//Instead of dispatching one long-running job, what if we dispatch multiple
//shorter jobs? Doing so has multiple benefits:
//First, workers won't get stuck for 5 hours processing refunds for a single
//conference; a worker may pick up a refunding job for conference A and then
//pick up a refunding job for conference B on the next loop

//        Second, if one refund fails, we can retry its job separately without worrying
//about skipping attendees who were refunded already.
//    Let's see how we can do that:
        $conference->attendees->each(function ($attendee) {
            RefundAttendee::dispatch($attendee);
        });
        //php artisan queue:work --queue=cancelations,default
        //php artisan queue:work --queue=default,cancelations

    }
}
