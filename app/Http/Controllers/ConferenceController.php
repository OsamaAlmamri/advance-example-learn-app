<?php

namespace App\Http\Controllers;

use App\Jobs\CancelConference;
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
        CancelConference::dispatch($conference)->onQueue('cancelations');

        //php artisan queue:work --queue=cancelations,default --timeout=18000

    }
}
