<?php declare(strict_types = 1);

namespace CyanBooks\Book\Domain;

use CyanBooks\Shared\Domain\InvalidStringValueObject;

final class InvalidBookTitle extends InvalidStringValueObject
{
    protected static function message(string $title): string
    {
        return sprintf(
            'The title <%s> does not match the expected format',
            $title
        );
    }
}
