<?php declare(strict_types = 1);

namespace CyanBooks\Book\Domain\Author;

final class AuthorCollection
{
    /* @var ArrayObject */
    private $collection;

    private function __construct()
    {
        $this->collection = new \ArrayObject();
    }

    public static function create(Author ...$authors): AuthorCollection
    {
        $collection = new self();
        foreach ($authors as $author) {
            $collection->add($author);
        }
        return $collection;
    }

    public function toArray(): array
    {
        return array_values((array) $this->collection);
    }

    private function add(Author $author): void
    {
        $this->ensureBookIsNotDuplicated($author);
        $this->saveBook($author);
    }

    private function ensureBookIsNotDuplicated(Author $author): void
    {
        if ($this->alreadyExists($author->id())) {
            throw DuplicatedAuthor::withId($author->id(), self::class);
        }
    }

    private function alreadyExists(AuthorId $authorId): bool
    {
        return $this->collection->offsetExists($authorId->value());
    }

    private function saveBook(Author $author): void
    {
        $id = $author->id()->value();
        $this->collection->offsetSet($id, $author);
    }
}
