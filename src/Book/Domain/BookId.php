<?php declare(strict_types = 1);

namespace CyanBooks\Book\Domain;

use CyanBooks\Shared\Domain\StringValueObject;

final class BookId extends StringValueObject
{
    protected function validate(string $value): void
    {
        if (!$this->isValid($value)) {
            throw new \InvalidArgumentException('Invalid Book Id');
        }
    }

    private function isValid(string $value): bool
    {
        return !empty($value);
    }
}
