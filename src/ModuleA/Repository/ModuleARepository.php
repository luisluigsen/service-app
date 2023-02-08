<?php

namespace ModuleA\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Persistence\ObjectManager;
use ModuleA\Entity\ModuleA;

class ModuleARepository extends ServiceEntityRepository
{
    private ObjectManager $manager;
    public function __construct(ManagerRegistry $registry)
    {
        $this->manager= $registry->getManager('module_a');
        parent::__construct($registry, ModuleA::class);
    }
    
    public function save(ModuleA $moduleA): void
    {
        $this->manager->persist($moduleA);
        $this->manager->flush();
    }
}