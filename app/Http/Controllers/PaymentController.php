<?php

namespace App\Http\Controllers;

use App\Payment\PaymentGateway;

class PaymentController
{


    public  function  store(PaymentGateway $paymentGateway)
    {

        $d=$paymentGateway->charge(50);
        return dd($d);
    }
}
