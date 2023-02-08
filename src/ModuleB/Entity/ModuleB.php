<?php

namespace ModuleB\Entity;

class ModuleB
{
    public function __construct(
        private readonly string $id = 'module_b_id'
    )
    {
    }


    public function getId(): string
    {
        return $this->id;
    }
}