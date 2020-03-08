<?php declare(strict_types = 1);

namespace CyanBooks\Test\Book\Application\Create;

use CyanBooks\Book\Domain\Book;
use CyanBooks\Book\Domain\Isbn;
use CyanBooks\Book\Domain\Author\Author;
use CyanBooks\Book\Domain\BookId;
use CyanBooks\Book\Domain\Author\AuthorId;
use CyanBooks\Book\Domain\BookTitle;
use CyanBooks\Book\Domain\Author\AuthorName;
use CyanBooks\Test\Book\Shared\TestCase;
use CyanBooks\Book\Domain\BookRepository;
use CyanBooks\Book\Application\Create\BookCreator;
use CyanBooks\Book\Application\Create\BookCreatorCommand;

final class BookCreatorTest extends TestCase
{
    private $repository;
    private $creator;

    public function setUp()
    {
        $this->repository = $this->mock(BookRepository::class);
        $this->creator = new BookCreator($this->repository);
    }

    /** @test */
    public function itShouldSaveABook(): void
    {
        $command = new BookCreatorCommand(
            '1',
            'Un nuevo caso para: Pol Colom(b)o',
            '978-9-6611-5391-1',
            '123',
            'Uri Ustrell'
        );

        $book = new Book(
            new BookId($command->id()),
            new BookTitle($command->title()),
            new Isbn($command->isbn()),
            new Author(
                new AuthorId($command->authorId()),
                new AuthorName($command->authorName())
            )
        );

        $this->repository
            ->shouldReceive('save')
            ->once()
            ->with($this->similarTo($book))
            ->andReturn();

        $this->creator->execute($command);
    }
}
