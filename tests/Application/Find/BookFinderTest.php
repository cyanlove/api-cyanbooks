<?php declare(strict_types = 1);

namespace CyanBooks\Test\Book\Application\Create;

use CyanBooks\Book\Domain\Book;
use CyanBooks\Book\Domain\Isbn;
use CyanBooks\Book\Domain\BookId;
use CyanBooks\Book\Domain\BookTitle;
use CyanBooks\Book\Domain\BookRepository;
use CyanBooks\Book\Application\Find\BookFinder;
use CyanBooks\Book\Application\Find\BookFinderQuery;
use CyanBooks\Test\Book\Shared\TestCase;
use Exception;

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
        $query = new BookFinderQuery('1');

        $book = new Book(
            new BookId('1'),
            new BookTitle('olakease'),
            new Isbn('978-9-6611-5391-1')
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
        $query = new BookFinderQuery('1');

        $this->repository
            ->shouldReceive('search')
            ->once()
            ->with($this->similarTo($query->id()))
            ->andReturnNull();

        $this->expectException(Exception::class);

        $this->finder->execute($query);
    }
}
