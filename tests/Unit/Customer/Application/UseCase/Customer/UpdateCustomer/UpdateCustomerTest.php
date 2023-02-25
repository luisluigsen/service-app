<?php

namespace App\Tests\Unit\Customer\Application\UseCase\Customer\UpdateCustomer;

use Customer\Application\UseCase\Customer\UpdateCustomer\DTO\UpdateCustomerInputDTO;
use Customer\Application\UseCase\Customer\UpdateCustomer\DTO\UpdateCustomerOutputDTO;
use Customer\Application\UseCase\Customer\UpdateCustomer\UpdateCustomer;
use Customer\Domain\Model\Customer;
use Customer\Domain\Repository\CustomerRepository;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class UpdateCustomerTest extends TestCase
{
    private const DATA = [
        'id'=>'3179b695-f3f0-4e88-b7a2-ef40da41d32d',
        'name'=> 'Peter',
        'address' => 'Fake Street 123',
        'age'=> 30,
        ];

    private const DATA_TO_UPDATE = [
        'id'=>'3179b695-f3f0-4e88-b7a2-ef40da41d32d',
        'name'=> 'Brian',
        'address' => 'Fake Street 123',
        'age'=> 32,
        ];

    private const EMPLOYEE_ID = '3179b695-f3f0-4e88-b7a2-ef40da41d111';

    private UpdateCustomerInputDTO $updateCustomerInputDTO;
    private CustomerRepository|MockObject $customerRepository;
    private UpdateCustomer $useCase;
    public function setUp(): void
    {
        $this->customerRepository = $this->createMock(CustomerRepository::class);

        $this->updateCustomerInputDTO = UpdateCustomerInputDTO::create
        (
            self::DATA_TO_UPDATE['id'],
            self::DATA_TO_UPDATE['name'],
            self::DATA_TO_UPDATE['address'],
            self::DATA_TO_UPDATE['age'],
        );

        $this->useCase = new UpdateCustomer($this->customerRepository);
    }

    public function testUpdateCustomer(): void
    {
        $customer = Customer::create(
            self::DATA['id'],
            self::DATA['name'],
            self::DATA['address'],
            self::DATA['age'],
            self::EMPLOYEE_ID,
        );

        $this->customerRepository
            ->expects($this->once())
            ->method('findOneByIdOrFail')
            ->with($this->updateCustomerInputDTO->id)
            ->willReturn($customer);

        $this->customerRepository
            ->expects($this->once())
            ->method('save')
            ->with(
                $this->callback(function (Customer $customer):bool{
                    return $customer->name() === $this->updateCustomerInputDTO->name
                        && $customer->address() === $this->updateCustomerInputDTO->address
                        && $customer->age() === $this->updateCustomerInputDTO->age;
                })
            );

        $responseDTO = $this->useCase->handle($this->updateCustomerInputDTO);

        self::assertInstanceOf(UpdateCustomerOutputDTO::class, $responseDTO);

        self::assertEquals($this->updateCustomerInputDTO->name, $responseDTO->customerData['name']);
        self::assertEquals($this->updateCustomerInputDTO->address, $responseDTO->customerData['address']);
        self::assertEquals($this->updateCustomerInputDTO->age, $responseDTO->customerData['age']);
    }
}