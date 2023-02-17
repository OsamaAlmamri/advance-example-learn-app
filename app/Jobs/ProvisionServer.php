<?php

namespace App\Jobs;

use App\Models\Server;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;

class ProvisionServer implements ShouldQueue
{
    private $server;
    private $payload;

    public function __construct(Server $server, $payload)
    {
        $this->server = $server;
        $this->payload = $payload;
    }

    public $tries = 20;
    //Using $maxExceptions, we configured the workers to fail the job if an
    //exception was thrown from inside the handle method on 3 different
    //attempts.
    //Now the job will be attempted 20 times, 3 out of those 20 attempts could
    //be due to an exception being thrown.
    public $maxExceptions = 3;


    public function handle()
    {

        //Here, we check if a forge_server_id is not assigned—which indicates we
        //haven't created the server yet—and create the server by contacting the
        //Forge API and updating forge_server_id with the ID from the response.


        if (!$this->server->forge_server_id) {
            $response = Http::timeout(5)->post(
                '.../servers', $this->payload
            )->throw()->json();
            $this->server->update([
                'forge_server_id' => $response['id']
            ]);
            //Now that the server is created on Forge, we send the job back to the queue
            //using release(120). This gives the server a couple of minutes to finish
            //provisioning.
            //43
            return $this->release(120);


        }
        //When a worker picks that job up again—after two minutes or more—, it's
        //going to check if the server is still provisioning and release the job back to
        //the queue with a 60 seconds delay.
        if ($this->server->stillProvisioning($this->server)) {
            return $this->release(60);
        }
        //Finally, we mark the server as ready if Forge is done provisioning it.
        $this->server->update([
            'is_ready' => true
        ]);
    }

//Handling Job Failure
//We shouldn't forget about cleaning up when the job fails. So, inside the
//failed() method, we are going to create an alert for the user—to know that
//the server creation has failed—and delete the server from our records:
    public function failed(Exception $e)
    {
        Alert::create([
            // ...
            'message' => "Provisioning failed!",
        ]);
        $this->server->delete();
    }
}
