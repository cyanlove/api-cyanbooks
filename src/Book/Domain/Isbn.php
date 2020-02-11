<?php declare(strict_types = 1);

namespace CyanBooks\Book\Domain;

use CyanBooks\Shared\Domain\StringValueObject;

final class Isbn extends StringValueObject
{
    protected function validate(string $value)
    {
        if (!$this->isValid($value)) {
            throw new \InvalidArgumentException('Invalid Isbn');
        }
    }

    private function isValid(string $value): bool
    {
        return !empty($value);
    }
}
