<?php

namespace App;

class AccountingHelper
{

    public static function findProfit($amount): float
    {
        $profit_percent = 10;
        return $profit_percent * $amount / 100;
    }

}
