<?php

namespace App\Rent\Repository;

use App\Rent\Entity\Rent;

interface RentRepository
{
    public function save(Rent $rent): void;
}