<?php

namespace App;

class  PostCard
{


    public static function resolveFacade($name)
    {
        return app()[$name];
    }


// this function will call when there is now function called
    public static function __callStatic(string $method, array $arguments)
    {

//        dd(app()['PostCard']);
//        dump(" call function :   $name  ", $arguments);

        return (self::resolveFacade('PostCard'))->$method(...$arguments);
    }
}
