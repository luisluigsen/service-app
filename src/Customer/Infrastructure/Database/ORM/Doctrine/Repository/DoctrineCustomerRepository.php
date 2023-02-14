<?php

namespace Customer\Infrastructure\Database\ORM\Doctrine\Repository;


use Customer\Domain\Model\Customer;
use Customer\Domain\Repository\CustomerRepository;
use Customer\Infrastructure\Database\ORM\Doctrine\Entity\DoctrineCustomer;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Persistence\ObjectManager;

class DoctrineCustomerRepository implements CustomerRepository
{
    private readonly ServiceEntityRepository $repository;
    private readonly ObjectManager $manager;

    public function __construct(ManagerRegistry $registry)
    {
        $this->repository = new ServiceEntityRepository($registry, DoctrineCustomer::class);
        $this->manager = $registry->getManager();
    }

    public function save(Customer $customer): void
    {
        $doctrineCustomer = DoctrineCustomer::createFromDomainCustomer($customer);
        
        $this->manager->persist($doctrineCustomer);
        $this->manager->flush();
    }
}