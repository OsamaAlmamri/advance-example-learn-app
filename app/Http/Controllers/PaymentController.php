<?php

namespace App\Http\Controllers;

use App\Orders\OrderDetails;
use App\Payment\PaymentGateway;

class PaymentController
{


    public  function  store(OrderDetails $orderDetails,PaymentGateway $paymentGateway)
    {

        $orderDetails->all();
        $d=$paymentGateway->charge(50);
        return dd($d);
    }
}
