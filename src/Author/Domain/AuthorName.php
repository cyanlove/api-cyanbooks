<?php declare(strict_types = 1);

namespace CyanBooks\Author\Domain;

use CyanBooks\Shared\Domain\StringValueObject;

final class AuthorName extends StringValueObject
{
    protected function validate(string $value): void
    {
        if (!$this->isValid($value)) {
            throw InvalidAuthorName::withValue($value);
        }
    }

    private function isValid(string $value): bool
    {
        return !empty($value);
    }
}
