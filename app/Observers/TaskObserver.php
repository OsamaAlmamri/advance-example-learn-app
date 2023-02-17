<?php

namespace App\Observers;


use App\Jobs\SendEmailJob;
use App\Jobs\TestJob;
use App\Models\Task;

class TaskObserver
{


    public function created(Task $task)
    {


        dispatch(new TestJob($task))->onQueue('payments');

    }
}
