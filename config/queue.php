<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Queue Connection Name
    |--------------------------------------------------------------------------
    |
    | Laravel's queue API supports an assortment of back-ends via a single
    | API, giving you convenient access to each back-end using the same
    | syntax for every one. Here you may define a default connection.
    |
    */

    'default' => env('QUEUE_CONNECTION', 'sync'),

    /*
    |--------------------------------------------------------------------------
    | Queue Connections
    |--------------------------------------------------------------------------
    |
    | Here you may configure the connection information for each server that
    | is used by your application. A default configuration has been added
    | for each back-end shipped with Laravel. You are free to add more.
    |
    | Drivers: "sync", "database", "beanstalkd", "sqs", "redis", "null"
    |
    */

    'connections' => [

        'sync' => [
            'driver' => 'sync',
        ],


        'database' => [
            'driver' => 'database',
            'table' => 'jobs',
            'queue' => 'default',
            //Preventing Job Duplication
            //When a worker picks a job up from the queue, it marks it as reserved so no
            //other worker picks that same job. Once it finishes running, it either removes
            //the job from the queue or releases it back to be retried. When a job is
            //released, it's no longer marked as reserved and can be picked up again by a
            //worker.
            //However, if the worker process crashes while in the middle of processing
            //the job, it will remain reserved forever and will never run.
            //To prevent this, Laravel sets a timeout for how long a job may remain in a
            //reserved state. This timeout is 90 seconds by default, and it's set inside the
            //config/queue.php configuration file:


            //Since we have the timeout for this job set to 5 hours, another worker may
            //pick it up—while still running—after 90 seconds since it'll be no longer
            //reserved.
            //This will lead to job duplication. Very bad outcome.
            //To prevent this, we have to always make sure the value of retry_after is
            //more than any timeout we set on a worker level or a job level:
//            'retry_after' => 18060,
            'retry_after' => 90,
            'after_commit' => false,
        ],

        //We had to configure retry_after a bit earlier. This will apply to all jobs
        //dispatched to our database queue connection. If a worker crashes while it's
        //in the middle of processing any job, other workers will not pick it up for 5
        //hours.
        //For that reason, we need to set retry_after to 18060 seconds for just our
        //cancelations queue. To do that, we'll need to create a completely separate
        //connection
        'database-cancelations' => [
            // 'driver' => 'database',
            // // ...
            'retry_after' => 18060,
        ],


        'beanstalkd' => [
            'driver' => 'beanstalkd',
            'host' => 'localhost',
            'queue' => 'default',
            'retry_after' => 90,
            'block_for' => 0,
            'after_commit' => false,
        ],

        'sqs' => [
            'driver' => 'sqs',
            'key' => env('AWS_ACCESS_KEY_ID'),
            'secret' => env('AWS_SECRET_ACCESS_KEY'),
            'prefix' => env('SQS_PREFIX', 'https://sqs.us-east-1.amazonaws.com/your-account-id'),
            'queue' => env('SQS_QUEUE', 'default'),
            'suffix' => env('SQS_SUFFIX'),
            'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
            'after_commit' => false,
        ],

        'redis' => [
            'driver' => 'redis',
            'connection' => 'default',
            'queue' => env('REDIS_QUEUE', 'default'),
            'retry_after' => 18060,
            'block_for' => null,
            'after_commit' => false,
        ],

    ],

    /*
    |--------------------------------------------------------------------------
    | Failed Queue Jobs
    |--------------------------------------------------------------------------
    |
    | These options configure the behavior of failed queue job logging so you
    | can control which database and table are used to store the jobs that
    | have failed. You may change them to any database / table you wish.
    |
    */

    'failed' => [
        'driver' => env('QUEUE_FAILED_DRIVER', 'database-uuids'),
        'database' => env('DB_CONNECTION', 'mysql'),
        'table' => 'failed_jobs',
    ],

];
