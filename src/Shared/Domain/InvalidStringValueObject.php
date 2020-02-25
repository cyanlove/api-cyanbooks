<?php declare(strict_types = 1);

namespace CyanBooks\Shared\Domain;

use InvalidArgumentException;

abstract class InvalidStringValueObject extends InvalidArgumentException
{
    public static function withValue(string $value): self
    {
        $message = static::message($value);

        return new static($message);
    }

    abstract protected static function message(string $value): string;
}
