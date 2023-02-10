<?php

namespace Customer\Repository;

use App\Customer\Repository\CustomerRepository;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Customer\Entity\Customer;
use Doctrine\Persistence\ObjectManager;

class DoctrineCustomerRepository implements CustomerRepository
{
    private readonly ServiceEntityRepository $repository;
    private readonly ObjectManager $manager;
    public function __construct(ManagerRegistry $registry)
    {
        $this->repository = new ServiceEntityRepository($registry, Customer::class);
        $this->manager = $registry->getManager();
    }

    public function save(Customer $customer): void
    {
        $this->manager->persist($customer);
        $this->manager->flush();
    }
}