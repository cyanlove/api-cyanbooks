<?php declare (strict_types = 1);

namespace CyanBooks\Shared\Domain;

abstract class ArrayValueObject
{
    /* @var array */
    protected $values;

    public function __construct(array $values)
    {
        $this->validate($values);
        $this->values = $values;
    }

    public function values(): array
    {
        return $this->values;
    }

    /**
     * Guard clause to check if the value follows the
     * required parameters.
     *
     * @param array $values
     * @throws InvalidArrayValueObject
     * @return void
     */
    abstract protected function validate(array $values): void;
}
