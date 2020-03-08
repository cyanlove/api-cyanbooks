<?php declare(strict_types = 1);

namespace CyanBooks\Book\Domain\Author;

use CyanBooks\Shared\Domain\InvalidStringValueObject;

final class InvalidBookId extends InvalidStringValueObject
{
    protected static function message(string $id): string
    {
        return sprintf(
            'The id <%s> does not match the expected format',
            $id
        );
    }
}
