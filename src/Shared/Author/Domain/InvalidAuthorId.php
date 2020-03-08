<?php declare(strict_types = 1);

namespace CyanBooks\Shared\Author\Domain;

use CyanBooks\Shared\Domain\InvalidStringValueObject;

final class InvalidAuthorId extends InvalidStringValueObject
{
    protected static function message(string $id): string
    {
        return sprintf(
            'The id <%s> does not match the expected format',
            $id
        );
    }
}
