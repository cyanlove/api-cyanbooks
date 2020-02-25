<?php declare(strict_types = 1);

namespace CyanBooks\Book\Application\Create;

use CyanBooks\Book\Domain\Book;
use CyanBooks\Book\Domain\Isbn;
use CyanBooks\Book\Domain\BookId;
use CyanBooks\Book\Domain\BookTitle;
use CyanBooks\Book\Domain\BookRepository;

final class BookCreator
{
    private $repository;

    public function __construct(BookRepository $repository)
    {
        $this->repository = $repository;
    }

    public function execute(BookCreatorCommand $command): void
    {
        $book = new Book(
            new BookId($command->id()),
            new BookTitle($command->title()),
            new Isbn($command->isbn())
        );

        $this->repository->save($book);
    }
}
