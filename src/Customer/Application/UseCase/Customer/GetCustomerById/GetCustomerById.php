<?php

namespace Customer\Application\UseCase\Customer\GetCustomerById;

use Customer\Application\UseCase\Customer\GetCustomerById\DTO\GetCustomerByIdInputDTO;
use Customer\Application\UseCase\Customer\GetCustomerById\DTO\GetCustomerByIdOutputDTO;
use Customer\Domain\Repository\CustomerRepository;

class GetCustomerById
{
    public function __construct(
        private readonly  CustomerRepository $repository
    )
    {
    }

    public function handle(GetCustomerByIdInputDTO $dto): GetCustomerByIdOutputDTO
    {
        return GetCustomerByIdOutputDTO::create($this->repository->findOneByIdOrFail($dto->id));
    }
}