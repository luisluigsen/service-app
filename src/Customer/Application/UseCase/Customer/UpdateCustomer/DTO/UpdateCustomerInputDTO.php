<?php

namespace Customer\Application\UseCase\Customer\UpdateCustomer\DTO;

use Customer\Domain\Model\Customer;
use Customer\Domain\Validation\Traits\AssertLengthRangeTrait;
use Customer\Domain\Validation\Traits\AssertMinimumAgeTrait;
use Customer\Domain\Validation\Traits\AssertNotNullTrait;

class UpdateCustomerInputDTO
{
    use AssertLengthRangeTrait, AssertMinimumAgeTrait, AssertNotNullTrait;

    private const ARGS = ['id', 'age'];

    private function __construct(
        public readonly ?string $id,
        public readonly ?string $name,
        public readonly ?string $address,
        public readonly ?int $age,
    )
    {
        $this->asserNotNull(self::ARGS, [$this->id, $this->age]);

        if (!is_null($this->name)){
            $this->assertValueRangeLength($this->name, Customer::NAME_MIN_LENGTH, Customer::NAME_MAX_LENGTH);
        }

        $this->assertMinimumAge($this->age, Customer::MIN_AGE);

    }

    public static function create(?string $id,?string $name, ?string $address, ?int $age): self
    {
        return new static($id, $name, $address, $age);
    }
}