<?php declare (strict_types = 1);

namespace CyanBooks\Shared\Domain;

use Ramsey\Uuid\Uuid;

abstract class UuidValueObject extends StringValueObject
{
    public static function random(): UuidValueObject
    {
        return new static((Uuid::uuid4())->toString());
    }

    abstract protected function exception(): InvalidUuidValueObject;

    /**
     * Guard clause to check if the value follows the
     * required parameters.
     *
     * @param string $value
     * @throws InvalidStringValueObject
     * @return void
     */
    protected function validate(string $value): void
    {
        if (!Uuid::isValid($value)) {
            throw $this->exception()::withValue($value);
        }
    }
}
