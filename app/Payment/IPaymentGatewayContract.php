<?php

namespace App\Payment;

interface IPaymentGatewayContract
{
    public function setDiscount($amount);

    public function charge($amount);
}
