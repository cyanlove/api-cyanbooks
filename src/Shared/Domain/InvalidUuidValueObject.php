<?php declare(strict_types = 1);

namespace CyanBooks\Shared\Domain;

abstract class InvalidUuidValueObject extends InvalidStringValueObject
{
    abstract protected static function message(string $value): string;
}
