<?php

namespace App\Payment;


use Illuminate\Support\Str;

class PaymentGateway
{


    private $currency;

    public function __construct($currency)
    {
        $this->currency = $currency;

    }

    public function charge($amount)
    {

        return [
            'amount' => $amount,
            'currency' => $this->currency,
            'conform_code' => Str::random()
        ];
    }

}
