<?php declare(strict_types = 1);

namespace CyanBooks\Book\Domain;

use CyanBooks\Shared\Domain\InvalidUuidValueObject;

final class InvalidBookId extends InvalidUuidValueObject
{
    protected static function message(string $id): string
    {
        return sprintf(
            'The id <%s> is not a valid BookId',
            $id
        );
    }
}
