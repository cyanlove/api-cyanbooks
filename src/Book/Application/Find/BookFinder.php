<?php declare(strict_types = 1);

namespace CyanBooks\Book\Application\Find;

use CyanBooks\Book\Domain\Book;
use CyanBooks\Book\Domain\BookId;
use CyanBooks\Book\Domain\BookNotExists;
use CyanBooks\Book\Domain\BookRepository;

final class BookFinder
{
    private $repository;

    public function __construct(BookRepository $repository)
    {
        $this->repository = $repository;
    }

    public function execute(BookFinderQuery $query): Book
    {
        $id = new BookId($query->id());

        $book = $this->repository->search($id);

        if (null === $book) {
            throw BookNotExists::withId($id);
        }

        return $book;
    }
}
