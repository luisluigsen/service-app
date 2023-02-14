<?php

namespace Customer\Domain\Repository;

use Customer\Domain\Model\Customer;

interface CustomerRepository
{
    public function save(Customer $customer): void;
}