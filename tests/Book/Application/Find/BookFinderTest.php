<?php declare(strict_types = 1);

namespace CyanBooks\Test\Book\Application\Create;

use CyanBooks\Book\Domain\Book;
use CyanBooks\Book\Domain\Isbn;
use CyanBooks\Book\Domain\BookId;
use CyanBooks\Book\Domain\BookTitle;
use CyanBooks\Book\Domain\BookNotExists;
use CyanBooks\Book\Domain\BookRepository;
use CyanBooks\Book\Domain\AuthorIdCollection;
use CyanBooks\Book\Application\Find\BookFinder;
use CyanBooks\Book\Application\Find\BookFinderQuery;
use CyanBooks\Shared\Author\Domain\AuthorId;
use CyanBooks\Test\Shared\TestCase;

final class BookFinderTest extends TestCase
{
    const VALID_ISBN = '978-9-6611-5391-1';

    private $repository;
    private $finder;

    public function setUp()
    {
        $this->repository = $this->mock(BookRepository::class);
        $this->finder = new BookFinder($this->repository);
    }

    /** @test */
    public function itShouldFindABook(): void
    {
        $bookId = BookId::random();

        $query = new BookFinderQuery((string) $bookId);

        $book = new Book(
            new BookId((string) $bookId),
            new BookTitle('olakease'),
            new Isbn(self::VALID_ISBN),
            AuthorIdCollection::create(
                AuthorId::random()
            )
        );

        $this->repository
            ->shouldReceive('search')
            ->once()
            ->with($this->similarTo($query->id()))
            ->andReturn($book);

        $this->assertSame(
            $book,
            $this->finder->execute($query)
        );
    }

    /** @test */
    public function itShouldThrowAnExceptionWhenItCantFindABook(): void
    {
        $query = new BookFinderQuery((string) BookId::random());

        $this->repository
            ->shouldReceive('search')
            ->once()
            ->with($this->similarTo($query->id()))
            ->andReturnNull();

        $this->expectException(BookNotExists::class);

        $this->finder->execute($query);
    }
}
