<?php declare(strict_types = 1);

namespace CyanBooks\Test\Book\Application\Create;

use CyanBooks\Book\Domain\Book;
use CyanBooks\Book\Domain\Isbn;
use CyanBooks\Book\Domain\BookId;
use CyanBooks\Book\Domain\BookTitle;
use CyanBooks\Book\Domain\BookRepository;
use CyanBooks\Book\Domain\AuthorIdCollection;
use CyanBooks\Book\Application\Create\BookCreator;
use CyanBooks\Book\Application\Create\BookCreatorCommand;
use CyanBooks\Shared\Author\Domain\AuthorId;
use CyanBooks\Test\Shared\TestCase;

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
            ['1', '2']
        );

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

        $this->repository
            ->shouldReceive('save')
            ->once()
            ->with($this->similarTo($book))
            ->andReturn();

        $this->creator->execute($command);
    }
}
