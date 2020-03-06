<?php declare(strict_types = 1);

namespace CyanBooks\Book\Domain;

use CyanBooks\Shared\Domain\InvalidStringValueObject;

final class InvalidAuthorName extends InvalidStringValueObject
{
    protected static function message(string $id): string
    {
        return sprintf(
            'The name <%s> does not match the expected format',
            $id
        );
    }
}
