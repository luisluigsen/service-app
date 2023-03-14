<?php

namespace Customer\Application\UseCase\Customer\CreateCustomer\DTO;

use Customer\Domain\Exception\InvalidArgumentException;
use Customer\Domain\Model\Customer;
use Customer\Domain\Validation\Traits\AssertLengthRangeTrait;
use Customer\Domain\Validation\Traits\AssertMinimumAgeTrait;
use Customer\Domain\Validation\Traits\AssertNotNullTrait;

class CreateCustomerInputDTO
{
    use AssertNotNullTrait, AssertLengthRangeTrait, AssertMinimumAgeTrait;

    private const ARGS = [
        'name',
        'address',
        'age',
        'employeeId'
    ];

    private const MINIMUM_AGE = 18;

    private function __construct(
        public readonly ?string $name,
        public readonly ?string $address,
        public readonly ?int $age,
        public readonly ?string $employeeId
    )
    {
        $this->asserNotNull(self::ARGS, [
            $this->name,
            $this->address,
            $this->age,
            $this->employeeId]);
        $this->assertValueRangeLength($this->name, Customer::NAME_MIN_LENGTH, Customer::NAME_MAX_LENGTH);
        $this->assertAddress($this->address);
        $this->assertMinimumAge($this->age, Customer::MIN_AGE);
    }

    public static function create(?string $name, ?string $address, ?int $age, ?string $employeeId): self
    {
        return new static($name, $address, $age, $employeeId);
    }

    private function assertAddress(string $address): void
    {
        if (is_null($address) || strlen($address) < 5) {
            throw InvalidArgumentException::createFromArgument('address');
        }
    }

}