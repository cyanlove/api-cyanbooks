<?php declare(strict_types = 1);

namespace CyanBooks\Book\Domain;

final class BookCollection
{
    /* @var ArrayObject */
    private $collection;

    private function __construct()
    {
        $this->collection = new \ArrayObject();
    }

    public static function create(Book ...$books): BookCollection
    {
        $collection = new self();
        foreach ($books as $book) {
            $collection->add($book);
        }
        return $collection;
    }

    public function toArray(): array
    {
        return array_values((array) $this->collection);
    }

    private function add(Book $book): void
    {
        $this->ensureBookIsNotDuplicated($book);
        $this->saveBook($book);
    }

    private function ensureBookIsNotDuplicated(Book $book): void
    {
        if ($this->alreadyExists($book->id())) {
            throw new \Exception(
                sprintf(
                    'Book with Id <%s> already exists in this collection.',
                    $book->id()->value()
                )
            );
        }
    }

    private function alreadyExists(BookId $bookId): bool
    {
        return $this->collection->offsetExists($bookId->value());
    }

    private function saveBook(Book $book): void
    {
        $id = $book->id()->value();
        $this->collection->offsetSet($id, $book);
    }
}
