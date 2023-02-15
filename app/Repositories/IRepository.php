<?php

namespace App\Repositories;

interface IRepository
{
    public function all();

    public function findById($customer_id);

    public function update($customer_id);

    public function delete($customer_id);
}
