<?php

namespace Customer\Application\UseCase\Customer\UpdateCustomer\DTO;

use Customer\Domain\Model\Customer;

class UpdateCustomerOutputDTO
{
    private function __construct(public readonly array $customerData)
    {
    }

    public static function createFromModel(Customer $customer): self
    {
        return new static([
            'id'=> $customer->id(),
            'name'=> $customer->name(),
            'address'=> $customer->address(),
            'age'=> $customer->age(),
            'employeeId'=> $customer->employeeId(),
        ]);
    }
}