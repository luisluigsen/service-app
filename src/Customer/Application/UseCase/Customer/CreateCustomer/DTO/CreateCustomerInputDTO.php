<?php

namespace Customer\Application\UseCase\Customer\CreateCustomer\DTO;

use Customer\Domain\Exception\InvalidArgumentException;
use Customer\Domain\Validation\Traits\AssertNotNullTrait;

class CreateCustomerInputDTO
{
    use AssertNotNullTrait;

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
        $this->assertNameLength($this->name);
        $this->assertAddress($this->address);
        $this->assertMinimumAge($this->age);
    }

    public static function create(?string $name, ?string $address, ?int $age, ?string $employeeId): self
    {
        return new static($name, $address, $age, $employeeId);
    }

    private function assertNameLength(string $name):void
    {

        if (strlen($name) < 2|| strlen($name)>10){
            throw InvalidArgumentException::createFromArgument('name');
        }

    }

    private function assertAddress(string $address): void
    {
        if (is_null($address) || strlen($address) < 5) {
            throw InvalidArgumentException::createFromArgument('address');
        }
    }

    private function assertMinimumAge(?int $age): void
    {
        if (!is_null($age) && $age < self::MINIMUM_AGE) {
            throw InvalidArgumentException::createFromMessage(sprintf('Age must be at least %d', self::MINIMUM_AGE));
        }
    }

}