<?php

namespace App\QueryFilters;

class Active extends Filter
{


    protected $col = "active";

    protected function applyFilter($builder)
    {
        return $builder->where('is_active', request()->active);
    }
}
