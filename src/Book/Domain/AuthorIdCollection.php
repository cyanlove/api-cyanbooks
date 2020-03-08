<?php declare(strict_types = 1);

namespace CyanBooks\Book\Domain;

use CyanBooks\Shared\Author\Domain\AuthorId;

final class AuthorIdCollection
{
    /* @var array */
    private $collection;

    private function __construct()
    {
        $this->collection = [];
    }

    public static function create(AuthorId ...$authorIds): AuthorIdCollection
    {
        $collection = new self();
        foreach ($authorIds as $authorId) {
            $collection->add($authorId);
        }
        $collection->removeDuplicated();
        return $collection;
    }

    public function toArray(): array
    {
        return $this->collection;
    }

    private function add(AuthorId $authorId): void
    {
        $this->collection[] = $authorId;
    }

    private function removeDuplicated(): void
    {
        $this->collection = array_unique(
            $this->collection
        );
    }
}
