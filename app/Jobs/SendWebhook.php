<?php

namespace App\Jobs;


use App\Models\Order;
use App\Models\Task;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;

class SendWebhook implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;


    //dding a retryUntil() public method to our job class instructs Laravel to set
    //an expiration date for the job. In this case, the job will expire after 24 hours
    public function retryUntil()
    {

        return now()->addDay();
        //Warning: The expiration is calculated by calling the retryUntil()
        //method when the job is first dispatched. If you release the job back,
        //the expiration will not be re-calculate

        //But remember, only one attempt is allowed by default when you start a
        //worker. In our case, we want this job to retry for an unlimited number of
        //times since we already have an expiration in place. To do this, we need to
        //set the $tries public property to 0:

    }

    public $tries = 0;


    public function handle()
    {
        //Inside the SendWebhook job, we're going to use Laravel's built-in HTTP client
        //to send requests to the integration URL:
        $response = Http::timeout(5)->post(
            $this->integration->url,
            $this->event->data
        );

        if ($response->failed()) {

            //First, let's catch an error response and release the job back to the queue
            //with an exponential backoff:
            $this->release(
                now()->addMinutes(15 * $this->attempts())
            );
        }


    }

    //If the HTTP request for the webhook kept failing for more than 24 hours,
    //Laravel will mark the job as failed. In that case, we want to notify the
    //developer of the integration so they can react.
    //To do this, we're going to add a failed() public method to our job class:

    public function failed(Exception $e)
    {

        //When a job exceeds the assigned number of attempts or reaches the
        //expiration time, the worker is going to call this failed() method and pass a
        //MaxAttemptsExceededException exception.
        //In other words, failed() is called when the worker is done retrying this job.

        
//        Mail::to(
//            $this->integration->developer_email
//        )->send(...);
    }


}
