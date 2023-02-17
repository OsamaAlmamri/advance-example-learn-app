<?php

namespace App\Jobs;



use App\Models\Task;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\Middleware\WithoutOverlapping;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class TestJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    private Task $task2;
    public $timeout = 10000;
//    public $queue = 'example_queue_name';
//    public $retries = 3;
//    public $backoff = 60;

    public function __construct(Task $task)
    {
        $this->task2 = $task->withoutRelations();
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $email="osama.moh.almamari@gmail.com";
        Mail::raw("hi osama ",function ($mess) use ($email){
            $mess->to($email);

        });

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
