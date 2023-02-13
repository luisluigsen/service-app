<?php

namespace Customer\Entity;

class Customer
{
    public function __construct(
        private readonly string $id,
        private string $name,
        private string $adress,
        private int $age
    )
    {
    }


    public function getName(): string
    {
        return $this->name;
    }


    public function setName(string $name): void
    {
        $this->name = $name;
    }


    public function getAdress(): string
    {
        return $this->adress;
    }


    public function setAdress(string $adress): void
    {
        $this->adress = $adress;
    }


    public function getAge(): int
    {
        return $this->age;
    }


    public function setAge(int $age): void
    {
        $this->age = $age;
    }


    public function getId(): string
    {
        return $this->id;
    }
}