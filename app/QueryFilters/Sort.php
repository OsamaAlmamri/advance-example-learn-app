<?php

namespace App\QueryFilters;

class Sort  extends Filter
{

    protected $col="sort";
    protected function applyFilter($builder)
    {
        return $builder->orderBy('title', request()->sort);
    }
}
