<?php declare (strict_types = 1);

namespace CyanBooks\Shared\Domain;

abstract class StringValueObject
{
    /* @var string */
    protected $value;

    public function __construct(string $value)
    {
        $this->validate($value);
        $this->value = $value;
    }

    public function value(): string
    {
        return $this->value;
    }

    public function __toString(): string
    {
        return $this->value();
    }

    /**
     * Guard clause to check if the value follows the
     * required parameters.
     *
     * @param string $value
     * @throws InvalidStringValueObject
     * @return void
     */
    abstract protected function validate(string $value): void;
}
