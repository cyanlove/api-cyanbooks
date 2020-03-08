<?php declare(strict_types = 1);

namespace CyanBooks\Book\Infrastructure;

use CyanBooks\Book\Domain\Author\Author;
use CyanBooks\Book\Domain\Author\AuthorId;
use CyanBooks\Book\Domain\Author\AuthorRepository;
use CyanBooks\Book\Domain\Author\DuplicatedAuthor;

final class InMemoryAuthorRepository implements AuthorRepository
{
    /* @var ArrayObject */
    private $repository;

    public function __construct()
    {
        $this->repository = new \ArrayObject();
    }

    public function save(Author $author): void
    {
        $this->ensureAuthorIsNotDuplicated($author);
        $this->saveAuthor($author);
    }

    public function search(AuthorId $id): ?Author
    {
        return $this->alreadyExists($id)
            ? $this->repository->offsetGet($id->value())
            : null;
    }

    private function ensureAuthorIsNotDuplicated(Author $author): void
    {
        if ($this->alreadyExists($author->id())) {
            throw DuplicatedAuthor::withId($author->id(), self::class);
        }
    }

    private function alreadyExists(AuthorId $authorId): bool
    {
        return $this->repository->offsetExists($authorId->value());
    }

    private function saveAuthor(Author $author): void
    {
        $id = $author->id()->value();
        $this->repository->offsetSet($id, $author);
    }
}
