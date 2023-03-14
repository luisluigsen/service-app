<?php

namespace Customer\Domain\Validation\Traits;

use Customer\Domain\Exception\InvalidArgumentException;

trait AssertNotNullTrait
{
    public function asserNotNull(array $args, array $values): void
    {
        $args = array_combine($args, $values);

        $emptyValues = [];
        foreach ($args as $key => $value) {
            if (is_null($value)) {
                $emptyValues[] = $key;
            }
        }

        if (!empty($emptyValues)) {
            throw InvalidArgumentException::createFromArray($emptyValues);
        }
    }
}