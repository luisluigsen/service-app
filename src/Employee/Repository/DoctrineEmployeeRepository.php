<?php

namespace App\Employee\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Persistence\ObjectManager;
use Employee\Entity\Employee;

class DoctrineEmployeeRepository implements EmpolyeeRepository
{
    private readonly ServiceEntityRepository $repository;
    private readonly ObjectManager $manager;
    public function __construct(ManagerRegistry $registry)
    {
      $this->repository = new ServiceEntityRepository($registry, Employee::class);
      $this->manager = $registry->getManager();
    }

    public function save(Employee $employee): void
    {
        $this->manager->persist($employee);
        $this->manager->flush();
    }
}