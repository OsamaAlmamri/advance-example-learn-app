<?php

namespace App\QueryFilters;

class Sort
{


    public function handle($request, \Closure $next)
    {

        if(!request()->has('sort'))
            return $next($request);
        else
        {
          $builder=  $next($request);
          return  $builder->orderBy('title',request()->sort);
        }

    }
}
