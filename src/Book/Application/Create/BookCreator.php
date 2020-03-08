<?php declare(strict_types = 1);

namespace CyanBooks\Book\Application\Create;

use CyanBooks\Book\Domain\Book;
use CyanBooks\Book\Domain\Isbn;
use CyanBooks\Book\Domain\Author\Author;
use CyanBooks\Book\Domain\BookId;
use CyanBooks\Book\Domain\Author\AuthorId;
use CyanBooks\Book\Domain\BookTitle;
use CyanBooks\Book\Domain\Author\AuthorName;
use CyanBooks\Book\Domain\BookRepository;
use CyanBooks\Book\Application\Create\BookCreatorCommand;

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
            new Isbn($command->isbn()),
            new Author(
                new AuthorId($command->authorId()),
                new AuthorName($command->authorName())
            )
        );

        $this->repository->save($book);
    }
}
