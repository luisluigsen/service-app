<?php

namespace Customer\Domain\Validation\Traits;

use Customer\Domain\Exception\InvalidArgumentException;

trait AssertMinimumAgeTrait
{
    public function assertMinimumAge(?int $age, int $minimumAge): void
    {
        if ($minimumAge > $age) {
            throw InvalidArgumentException::createFromMessage(sprintf('Age must be at least %d', $minimumAge));
        }
    }
}