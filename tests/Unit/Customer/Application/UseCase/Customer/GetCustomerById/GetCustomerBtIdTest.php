<?php

namespace App\Tests\Unit\Customer\Application\UseCase\Customer\GetCustomerById;

use Customer\Application\UseCase\Customer\GetCustomerById\DTO\GetCustomerByIdInputDTO;
use Customer\Application\UseCase\Customer\GetCustomerById\DTO\GetCustomerByIdOutputDTO;
use Customer\Application\UseCase\Customer\GetCustomerById\GetCustomerById;
use Customer\Domain\Model\Customer;
use Customer\Domain\Repository\CustomerRepository;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class GetCustomerBtIdTest extends TestCase
{
    private const CUSTOMER_DATA = [
        'id'=>'3179b695-f3f0-4e88-b7a2-ef40da41d32d',
        'name'=> 'Peter',
        'address' => 'Fake Street 123',
        'age'=> 30,
        'employeeId'=> '3179b695-f3f0-4e88-b7a2-ef40da41d000'
    ];

    private CustomerRepository|MockObject $customerRepository;

    private GetCustomerById $useCase;

    public function setUp(): void
    {
        $this->customerRepository = $this->createMock(CustomerRepository::class);

        $this->useCase = new GetCustomerById($this->customerRepository);
    }

    public function testGetCustomerById(): void
    {
        $inputDto = GetCustomerByIdInputDTO::create(self::CUSTOMER_DATA['id']);

        $customer = Customer::create(
            self::CUSTOMER_DATA['id'],
            self::CUSTOMER_DATA['name'],
            self::CUSTOMER_DATA['address'],
            self::CUSTOMER_DATA['age'],
            self::CUSTOMER_DATA['employeeId'],
        );

        $this->customerRepository
            ->expects($this->once())
            ->method('findOneByIdOrFail')
            ->with($inputDto->id)
            ->willReturn($customer);

        $responseDTO = $this->useCase->handle($inputDto);

        self::assertInstanceOf(GetCustomerByIdOutputDTO::class, $responseDTO);
        
        self::assertEquals(self::CUSTOMER_DATA['id'], $responseDTO->id);
        self::assertEquals(self::CUSTOMER_DATA['name'], $responseDTO->name);
        self::assertEquals(self::CUSTOMER_DATA['address'], $responseDTO->address);
        self::assertEquals(self::CUSTOMER_DATA['age'], $responseDTO->age);
        self::assertEquals(self::CUSTOMER_DATA['employeeId'], $responseDTO->employeeId);
    }
}