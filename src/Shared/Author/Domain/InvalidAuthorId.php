<?php declare(strict_types = 1);

namespace CyanBooks\Shared\Author\Domain;

use CyanBooks\Shared\Domain\InvalidUuidValueObject;

final class InvalidAuthorId extends InvalidUuidValueObject
{
    protected static function message(string $id): string
    {
        return sprintf(
            'The id <%s> is not a valid AuthorId',
            $id
        );
    }
}
