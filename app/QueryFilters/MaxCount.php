<?php

namespace App\QueryFilters;

class MaxCount extends Filter
{


    protected $col = "limit";

    protected function applyFilter($builder)
    {
        return $builder->take(request()->limit);
    }
}
