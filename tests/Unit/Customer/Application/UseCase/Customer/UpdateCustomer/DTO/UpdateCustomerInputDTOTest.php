<?php

namespace App\Tests\Unit\Customer\Application\UseCase\Customer\UpdateCustomer\DTO;

use Customer\Adapter\Framework\Http\DTO\UpdateCustomerRequestDTO;
use Customer\Application\UseCase\Customer\UpdateCustomer\DTO\UpdateCustomerInputDTO;
use Customer\Domain\Exception\InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class UpdateCustomerInputDTOTest extends TestCase
{
    private const DATA = [
        'id'=>'3179b695-f3f0-4e88-b7a2-ef40da41d32d',
        'name'=> 'Brian',
        'address' => 'Fake Street 123',
        'age'=> 32,
        'employeeId'=> '3179b695-f3f0-4e88-b7a2-ef40da41d000'
    ];

    public function testCreateDTO(): void
    {
        $dto = UpdateCustomerInputDTO::create(
            self::DATA['id'],
            self::DATA['name'],
            self::DATA['address'],
            self::DATA['age']
        );

        self::assertInstanceOf(UpdateCustomerInputDTO::class, $dto);
    }

    public function testCreateWithNullId(): void
    {
        self::expectException(InvalidArgumentException::class);

        UpdateCustomerInputDTO::create(
            null,
            self::DATA['name'],
            self::DATA['address'],
            self::DATA['age']
        );
    }

    public function testCreateWithNullAge(): void
    {
        self::expectException(InvalidArgumentException::class);

        UpdateCustomerInputDTO::create(
            self::DATA['id'],
            self::DATA['name'],
            self::DATA['address'],
            null
        );
    }

    public function testCreateWithInvalidAge(): void
    {
        self::expectException(InvalidArgumentException::class);

        UpdateCustomerInputDTO::create(
            self::DATA['id'],
            self::DATA['name'],
            self::DATA['address'],
            2
        );
    }
}