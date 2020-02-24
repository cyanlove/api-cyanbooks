<?php declare(strict_types = 1);

namespace CyanBooks\Book\Infrastructure;

use CyanBooks\Book\Domain\Book;
use CyanBooks\Book\Domain\BookId;
use CyanBooks\Book\Domain\BookRepository;

final class InMemoryBookRepository implements BookRepository
{
    /* @var ArrayObject */
    private $repository;

    public function __construct()
    {
        $this->repository = new \ArrayObject();
    }

    public function save(Book $book): void
    {
        $this->ensureBookIsNotDuplicated($book);
        $this->saveBook($book);
    }

    public function search(BookId $id): ?Book
    {
        return $this->alreadyExists($id)
            ? $this->repository->offsetGet($id->value())
            : null;
    }

    private function ensureBookIsNotDuplicated(Book $book): void
    {
        if ($this->alreadyExists($book->id())) {
            throw new \Exception(
                sprintf(
                    'Book with Id <%s> already exists in this repository.',
                    $book->id()->value()
                )
            );
        }
    }

    private function alreadyExists(BookId $bookId): bool
    {
        return $this->repository->offsetExists($bookId->value());
    }

    private function saveBook(Book $book): void
    {
        $id = $book->id()->value();
        $this->repository->offsetSet($id, $book);
    }
}
