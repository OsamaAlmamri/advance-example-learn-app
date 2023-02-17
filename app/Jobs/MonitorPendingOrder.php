<?php

namespace App\Jobs;


use App\Models\Order;
use App\Models\Task;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\Middleware\WithoutOverlapping;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class MonitorPendingOrder implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    private Order $order;

//Ensuring the Job Has Enough Attempts
//Every time the job is released back to the queue, it'll count as an attempt.
//We need to make sure our job has enough $tries to run 4 times:
    public $tries = 4;

//
    public function __construct(Order $order)
    {
        $this->order = $order->withoutRelations();
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {

//If the user confirmed or canceled the order say after 20 minutes, the job will
//be deleted from the queue when it runs on the attempt at 30 minutes and
//no SMS will be sent.
        if ($this->order->status == Order::CONFIRMED ||
            $this->order->status == Order::CANCELED) {
            return;
        }


        //When the job runs—after an hour—, we'll check if the order was canceled
        //or confirmed and just return from the handle() method. Using return will
        //make the worker consider the job as successful and remove it from the
        //queue.
        if ($this->order->olderThan(59, 'minutes')) {
            $this->order->markAsCanceled();
            return;
        }

        // SMS::send(...);
        $this->release(
            now()->addMinutes(15)
        //Using release() inside a job has the same effect as using delay() while
        //dispatching. The job will be released back to the queue and workers will run
        //35
        //it again after 15 minutes
        );


    }

//    public $uniqueFor = 1;
//
//    /**
//     * The unique ID of the job.
//     *
//     * @return string
//     */
//    public function uniqueId()
//    {
//        return $this->task2->id;
//    }

}
