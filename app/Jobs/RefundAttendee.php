<?php

namespace App\Jobs;
use App\Models\Attendee;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;

class RefundAttendee implements ShouldQueue
{
    public $tries = 3;
    public $timeout = 60;
    private $attendee;
    public function __construct(Attendee $attendee)
    {
        $this->attendee = $attendee;
    }
    public function handle()
    {
        $this->attendee->invoice->refund();
//        Mail::to($this->attendee)->send(...);
    }


}
