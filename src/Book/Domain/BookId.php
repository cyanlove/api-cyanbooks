<?php declare(strict_types = 1);

namespace CyanBooks\Book\Domain;

use CyanBooks\Shared\Domain\UuidValueObject;
use CyanBooks\Shared\Domain\InvalidUuidValueObject;

final class BookId extends UuidValueObject
{
    protected function exception(): InvalidUuidValueObject
    {
        return new InvalidBookId;
    }
}
