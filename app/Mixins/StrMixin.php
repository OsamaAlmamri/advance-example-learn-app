<?php

namespace App\Mixins;

use Illuminate\Support\Str;

class StrMixin
{

    public function partNumber()
    {
        return function ($part) {

            return 'AB-' . substr($part, 0, 3) . '-' . substr($part, 3);
        };
    }


    public function prefix()
    {
        return function ($string, $prefix = "AB-") {

            return $prefix . $string;
        };
    }


}
