<?php declare(strict_types = 1);

namespace CyanBooks\Book\Application\Create;

use CyanBooks\Book\Domain\Book;
use CyanBooks\Book\Domain\Isbn;
use CyanBooks\Book\Domain\BookId;
use CyanBooks\Book\Domain\BookTitle;
use CyanBooks\Book\Domain\BookRepository;
use CyanBooks\Book\Domain\AuthorIdCollection;
use CyanBooks\Book\Application\Create\BookCreatorCommand;
use CyanBooks\Shared\Author\Domain\AuthorId;

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
            AuthorIdCollection::create(
                ...array_map(
                    function($authorId) {
                        return new AuthorId($authorId);
                    },
                    $command->authorIds()
                )
            )
        );

        $this->repository->save($book);
    }
}
