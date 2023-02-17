<?php

namespace App\Http\Controllers;

use App\Jobs\MonitorPendingOrder;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function store()
    {
        $order = Order::create([
            'status' => Order::PENDING,
            // ...
        ]);
        //after an hour—, we'll check if the order was canceled
        //or confirmed and just return from the handle() method. Using return will
        //make the worker consider the job as successful and remove it from the
        //queue.
        MonitorPendingOrder::dispatch($order)->delay(
            now()->addHour()
        );

//It might be a good idea to send the user an SMS notification to remind them
//about their order before completely canceling it. So let's send an SMS every
//34
//15 minutes until the user completes the checkout or we cancel the order
//after 1 hour.
        MonitorPendingOrder::dispatch($order)->delay(
            now()->addMinutes(15)
        );

    }

}
