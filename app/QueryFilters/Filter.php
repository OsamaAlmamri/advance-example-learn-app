<?php

namespace App\QueryFilters;

abstract class Filter
{
    protected $col;

    public function handle($request, \Closure $next)
    {

        if (!request()->has($this->col))
            return $next($request);
        else {
            $builder = $next($request);
            return $this->applyFilter($builder);
        }

    }

    protected abstract function applyFilter($builder);
}
