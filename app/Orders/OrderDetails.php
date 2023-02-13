<?php

namespace App\Orders;

use App\Payment\BankPaymentGateway;
use App\Payment\IPaymentGatewayContract;

class OrderDetails
{
    private  $paymentGateway;

    public function __construct(IPaymentGatewayContract $paymentGateway)
    {
        $this->paymentGateway = $paymentGateway;

    }

    public function all()
    {

        $this->paymentGateway->setDiscount(20);

        return [
            'name' => "osama Almamari",
            "address" => "Sanaa  - Yemen",
            "phone" => "+967779558800"

        ];
    }

}
