<?php

namespace App\Http\Controllers;

use App\Orders\OrderDetails;
use App\Payment\BankPaymentGateway;
use App\Payment\IPaymentGatewayContract;

class PaymentController
{


    public  function  store(OrderDetails $orderDetails, IPaymentGatewayContract $paymentGateway)
    {

        $orderDetails->all();
        $d=$paymentGateway->charge(50);
        return dd($d);
    }
}
