<?php

namespace App\Payment;


use Illuminate\Support\Str;

class CreditPaymentGateway implements IPaymentGatewayContract
{


    private $currency;
    private $discount;

    public function __construct($currency)
    {
        $this->currency = $currency;
        $this->discount = 0;

    }

    public function setDiscount($amount)
    {
        $this->discount = $amount;
    }

    public function charge($amount)
    {

        $discount = $amount * ($this->discount / 100);
        $fee= $amount * .003;
        return [
            'amount' =>( $amount - $discount)+$fee,
            'fee' => $fee,
            'discount' => $discount,
            'discount_percent' => $this->discount . "%",
            'currency' => $this->currency,
            'conform_code' => Str::random()
        ];
    }

}
