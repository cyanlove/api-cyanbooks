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
        $query = new BookFinderQuery('550e8400-e29b-41d4-a716-446655440000');

        $book = new Book(
            new BookId('550e8400-e29b-41d4-a716-446655440000'),
            new BookTitle('olakease'),
            new Isbn('978-9-6611-5391-1'),
            AuthorIdCollection::create(new AuthorId('1'))
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
        $query = new BookFinderQuery('550e8400-e29b-41d4-a716-446655440000');

        $this->repository
            ->shouldReceive('search')
            ->once()
            ->with($this->similarTo($query->id()))
            ->andReturnNull();

        $this->expectException(BookNotExists::class);

        $this->finder->execute($query);
    }
}
