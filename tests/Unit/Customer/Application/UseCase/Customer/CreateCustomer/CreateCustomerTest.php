<?php

namespace App\Tests\Unit\Customer\Application\UseCase\Customer\CreateCustomer;

use Customer\Application\UseCase\Customer\CreateCustomer\CreateCustomer;
use Customer\Application\UseCase\Customer\CreateCustomer\DTO\CreateCustomerInputDTO;
use Customer\Application\UseCase\Customer\CreateCustomer\DTO\CreateCustomerOutputDTO;
use Customer\Domain\Model\Customer;
use Customer\Domain\Repository\CustomerRepository;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class CreateCustomerTest extends TestCase
{
    private const VALUES = [
        'name' => 'Peter',
        'address'=>'street 123',
        'age'=> 30,
        'employeeId'=>'d0788b69-a806-4094-ab55-06396dcd19c0'
    ];

    private CustomerRepository|MockObject $customerRepository;
    private CreateCustomer $useCase;

    public function setUp(): void
    {
        $this->customerRepository = $this->createMock(CustomerRepository::class);
        $this->useCase = new CreateCustomer($this->customerRepository);
    }

    public function testCreateCustomer(): void
    {
       $dto = CreateCustomerInputDTO::create(
            self::VALUES['name'],
            self::VALUES['address'],
            self::VALUES['age'],
            self::VALUES['employeeId'],
        );

        $this->customerRepository->expects($this->once())
            ->method('save')
            ->with(
                $this->callback(function (Customer $customer):bool{
                    return $customer->name() === self::VALUES['name']
                        && $customer->address() === self::VALUES['address']
                        && $customer->age() === self::VALUES['age']
                        && $customer->employeeId()=== self::VALUES['employeeId'];
                })
            );

        $outputDTO = $this->useCase->handle($dto);

        self::assertInstanceOf(CreateCustomerOutputDTO::class, $outputDTO);

    }
}