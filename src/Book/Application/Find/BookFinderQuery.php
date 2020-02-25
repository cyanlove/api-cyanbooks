<?php declare(strict_types = 1);

namespace CyanBooks\Book\Application\Find;

final class BookFinderQuery
{
    private $id;

    public function __construct(string $id)
    {
        $this->id = $id;
    }

    public function id(): string
    {
        return $this->id;
    }
}
