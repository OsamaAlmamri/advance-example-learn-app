<?php

namespace App\Repositories;

use App\Models\Customer;

class CustomerRepository
{

    public function all()
    {

        return Customer::orderBy("name")
            ->where('active', 1)
            ->with('user')
            ->get()->map(function ($customer){
               return $customer->format();
            });
    }

    public function  findById($customer_id)
    {
        $customer=Customer::where('id',$customer_id)
            ->with('user')
            ->firstOrFail();
        return $customer->format();
    }



}
