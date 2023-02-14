<?php

namespace App;

use Illuminate\Support\Facades\Mail;

class PostCardSendingService
{

    private $country;
    private $width;
    private $height;

    public function __construct($country, $width, $height)
    {

        $this->country = $country;
        $this->width = $width;
        $this->height = $height;
    }

    public  function hello($message,$email)
    {
        Mail::raw($message,function ($mess) use ($email){
            $mess->to($email);

        });

        return dump("postcard  was send with message :" . $message);
//        return $this;
    }

    public function hello2($message)
    {

        return dump(" message :" . $message);
    }

}
