<?php

namespace App\QueryFilters;

class Active
{


    public function handle($request, \Closure $next)
    {

        if(!request()->has('active'))
            return $next($request);
        else
        {
          $builder=  $next($request);
          return  $builder->where('is_active',request()->active);
        }

    }
}
