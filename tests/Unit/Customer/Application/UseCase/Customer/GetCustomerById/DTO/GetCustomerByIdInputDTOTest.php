<?php

namespace App\Tests\Unit\Customer\Application\UseCase\Customer\GetCustomerById\DTO;

use Customer\Application\UseCase\Customer\GetCustomerById\DTO\GetCustomerByIdInputDTO;
use Customer\Domain\Exception\InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class GetCustomerByIdInputDTOTest extends TestCase
{
    private const CUSTOMER_ID = '3179b695-f3f0-4e88-b7a2-ef40da41d32d';

    public function testGetCustomerByIdInputDTO(): void
    {
        $dto = GetCustomerByIdInputDTO::create(self::CUSTOMER_ID);

        self::assertInstanceOf(GetCustomerByIdInputDTO::class, $dto);
        self::assertEquals(self::CUSTOMER_ID, $dto->id);
    }

    public function testCreateGetCustomerByIdInputDTOWithNullValue(): void
    {
        self::expectException(InvalidArgumentException::class);
        self::expectExceptionMessage('Invalid arguments [id]');

        GetCustomerByIdInputDTO::create(null);
    }
}