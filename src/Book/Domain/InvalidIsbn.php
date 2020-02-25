<?php declare(strict_types = 1);

namespace CyanBooks\Book\Domain;

use CyanBooks\Shared\Domain\InvalidStringValueObject;

final class InvalidIsbn extends InvalidStringValueObject
{
    protected static function message(string $isbn): string
    {
        return sprintf(
            'The isbn <%s> does not match the expected format',
            $isbn
        );
    }
}
