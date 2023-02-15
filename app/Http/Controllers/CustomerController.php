<?php

namespace App\Http\Controllers;

use App\Repositories\CustomerRepository;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    //

    private CustomerRepository $customerRepository;

    public function __construct(CustomerRepository $customerRepository)
    {
        $this->customerRepository = $customerRepository;
    }

    public function index()
    {
        $customers = $this->customerRepository->all();
        return $customers;
    }

    public function show($id)
    {
        $customer = $this->customerRepository->findById($id);
        return $customer;
    }

    public function update($id)
    {

        $customer = $this->customerRepository->update($id);

        return redirect('/customers/' . $id);
    }

    public function delete($id)
    {
        $this->customerRepository->delete($id);
        return redirect('/customers');
    }
}
