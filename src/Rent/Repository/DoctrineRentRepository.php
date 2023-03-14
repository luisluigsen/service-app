<?php

namespace App\Rent\Repository;

use App\Rent\Entity\Rent;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Persistence\ObjectManager;

class DoctrineRentRepository implements RentRepository
{
    private readonly ServiceEntityRepository $repository;
    private readonly ObjectManager $manager;

    public function __construct(ManagerRegistry $registry)
    {
        $this->repository = new ServiceEntityRepository($registry, Rent::class);
        $this->manager = $registry->getManager();
    }

    public function save(Rent $rent): void
    {
        $this->manager->persist($rent);
        $this->manager->flush();
    }
}