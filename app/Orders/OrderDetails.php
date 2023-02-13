<?php

namespace App\Orders;

use App\Payment\PaymentGateway;

class OrderDetails
{
    private PaymentGateway $paymentGateway;

    public function __construct(PaymentGateway $paymentGateway)
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
