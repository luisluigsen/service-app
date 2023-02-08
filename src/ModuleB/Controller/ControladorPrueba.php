<?php

namespace ModuleB\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class ControladorPrueba
{
    public function __invoke():Response
    {
        return new JsonResponse(['message'=> 'Modulo B funciona']);
    }
}