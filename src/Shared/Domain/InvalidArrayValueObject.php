<?php declare(strict_types = 1);

namespace CyanBooks\Shared\Domain;

use InvalidArgumentException;

abstract class InvalidArrayValueObject extends InvalidArgumentException
{
    public static function withValue(array $value): self
    {
        $message = static::message($value);

        return new static($message);
    }

    abstract protected static function message(array $value): string;
}
