<?php

namespace App\Tests\Unit\Customer\Application\UseCase\Customer\CreateCustomer\DTO;

use Customer\Application\UseCase\Customer\CreateCustomer\DTO\CreateCustomerInputDTO;
use Customer\Domain\Exception\InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class CreateCustomerInputDTOTest extends TestCase
{
    private const VALUES = [
        'name' => 'Peter',
        'address'=>'street 123',
        'age'=> 30,
        'employeeId'=>'d0788b69-a806-4094-ab55-06396dcd19c0'
    ];
    public function testCreate(): void
    {
        $dto = CreateCustomerInputDTO::create(
            self::VALUES['name'],
            self::VALUES['address'],
            self::VALUES['age'],
            self::VALUES['employeeId'],
        );

        self::assertInstanceOf(CreateCustomerInputDTO::class, $dto);

        self::assertEquals(self::VALUES['name'], $dto->name);
        self::assertEquals(self::VALUES['address'], $dto->address);
        self::assertEquals(self::VALUES['age'], $dto->age);
        self::assertEquals(self::VALUES['employeeId'], $dto->employeeId);
    }

    public function testCreateWithNullValue(): void
    {
        self::expectException(InvalidArgumentException::class);
        self::expectExceptionMessage('Invalid arguments [name, age]');

        CreateCustomerInputDTO::create(
            null,
            self::VALUES['address'],
            null,
            self::VALUES['employeeId'],
        );
    }

    public function testNameLengthIsGreaterThan2():void
    {
        self::expectException(InvalidArgumentException::class);
        self::expectExceptionMessage('Value must be min [2] and max [10] characters');

        CreateCustomerInputDTO::create(
        'A',
        self::VALUES['address'],
        self::VALUES['age'],
        self::VALUES['employeeId'],
        );
    }

    public function testNameLengthIsGreaterThan10():void
    {
        self::expectException(InvalidArgumentException::class);
        self::expectExceptionMessage('Value must be min [2] and max [10] characters');

        CreateCustomerInputDTO::create(
            'asdfghjkñsfsksdkdjdjksksk',
            self::VALUES['address'],
            self::VALUES['age'],
            self::VALUES['employeeId'],
        );
    }

    public function testCreateWithInvalidAddress(): void
    {
        self::expectException(InvalidArgumentException::class);
        self::expectExceptionMessage('Invalid arguments [address]');

        CreateCustomerInputDTO::create(
            self::VALUES['name'],
            'abc',
            self::VALUES['age'],
            self::VALUES['employeeId']
        );
    }

    public function testAgeHasToBeAtLeast18():void
    {
        self::expectException(InvalidArgumentException::class);
        self::expectExceptionMessage('Age must be at least 18');

        CreateCustomerInputDTO::create(
            self::VALUES['name'],
            self::VALUES['address'],
            17,
            self::VALUES['employeeId']
        );
    }
}