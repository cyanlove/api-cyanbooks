<?php declare(strict_types = 1);

namespace CyanBooks\Shared\Author\Domain;

use CyanBooks\Shared\Domain\UuidValueObject;
use CyanBooks\Shared\Domain\InvalidUuidValueObject;

final class AuthorId extends UuidValueObject
{
    protected function exception(): InvalidUuidValueObject
    {
        return new InvalidAuthorId;
    }
}
