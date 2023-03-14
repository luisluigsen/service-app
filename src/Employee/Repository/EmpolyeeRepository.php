<?php

namespace App\Employee\Repository;

use Employee\Entity\Employee;

interface EmpolyeeRepository
{
    public function save(Employee $employee): void;
}