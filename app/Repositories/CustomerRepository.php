<?php

namespace App\Repositories;

use App\Models\Customer;

class CustomerRepository implements IRepository
{

    public function all()
    {

        return Customer::orderBy("name")
            ->where('active', 1)
            ->with('user')
            ->get()->map->format();
    }

    public function findById($customer_id)
    {
        return Customer::where('id', $customer_id)
            ->with('user')
            ->firstOrFail()->format();
    }

    public function update($customer_id)
    {
        $customer = Customer::where('id', $customer_id)
            ->with('user')
            ->firstOrFail();

        return $customer->update(request()->only('name'));
    }

    public function delete($customer_id)
    {
        $customer = Customer::where('id', $customer_id)->delete();
    }


}
