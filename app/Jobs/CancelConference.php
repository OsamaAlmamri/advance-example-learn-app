<?php

namespace App\Jobs;

use App\Models\Conference;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CancelConference implements ShouldQueue
{
    private $conference;

    public function __construct(Conference $conference)
    {
        $this->conference = $conference;
    }
    //Our job may need several minutes to complete. However, workers—by
    //default—will give every job 60 seconds to finish. We need to tell our
    //workers to give us more time:

    public $timeout = 18000;
//Now, only the CancelConference job will be given 5 hours to finish while all
//the other jobs will be given 60 seconds


    public function handle()
    {
        //We loop over the list of attendees, refund the tickets using our billing
        //provider's API, and finally send an email to notify each attendee.
        $this->conference->attendees->each(function ($attendee) {
            $attendee->invoice->refund();
//            Mail::to($attendee)->send(...);
        });
    }
}
