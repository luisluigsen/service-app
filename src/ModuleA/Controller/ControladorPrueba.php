<?php

namespace ModuleA\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class ControladorPrueba
{
    public function __invoke():Response
    {
        return new JsonResponse(['message'=> 'Modulo A funciona']);
    }
}