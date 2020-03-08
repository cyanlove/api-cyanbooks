<?php declare(strict_types = 1);

namespace CyanBooks\Author\Domain;

use CyanBooks\Shared\Author\Domain\AuthorId;

final class Author
{
    /** @var AuthorId */
    private $id;

    /** @var AuthorName */
    private $name;

    public function __construct(AuthorId $id, AuthorName $name)
    {
        $this->id = $id;
        $this->name = $name;
    }

    public function id(): AuthorId
    {
        return $this->id;
    }

    public function name(): AuthorName
    {
        return $this->name;
    }
}
