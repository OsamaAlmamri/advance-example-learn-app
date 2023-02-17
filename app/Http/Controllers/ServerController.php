<?php

namespace App\Http\Controllers;

use App\Jobs\ProvisionServer;
use App\Models\Server;
use Illuminate\Http\Request;

class ServerController extends Controller
{


    public function store()
    {
        //First, we create a record in our database to store the server and set
        //is_ready = false to indicate that this server is not usable yet. Then, we
        //dispatch a ProvisionServer job to the queue.
        $server = Server::create([
            'is_ready' => false,
            'forge_server_id' => null
        ]);
        ProvisionServer::dispatch($server, request('server_payload'));
    }

}
