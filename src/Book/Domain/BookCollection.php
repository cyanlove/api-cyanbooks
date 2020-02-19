<?php declare(strict_types = 1);

namespace CyanBooks\Book\Domain;

final class BookCollection
{
    /* @var array */
    private $books;

    private function __construct()
    {
        $this->books = new \ArrayObject();
    }

    public static function create(Book ...$books): BookCollection
    {
        $collection = new self();
        foreach ($books as $book) {
            $collection->add($book);
        }
        return $collection;
    }

    public function toArray()
    {
        return array_values((array) $this->books);
    }

    private function add(Book $book)
    {
        $this->ensureBookIsNotDuplicated($book);
        $this->books->offsetSet($book->id()->value(), $book);
    }

    private function ensureBookIsNotDuplicated(Book $book)
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
        return $this->books->offsetExists($bookId->value());
    }
}
