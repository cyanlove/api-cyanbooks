<?php declare(strict_types = 1);

namespace CyanBooks\Test\Book\Infrastructure;

use Exception;
use CyanBooks\Book\Domain\Book;
use CyanBooks\Book\Domain\Isbn;
use CyanBooks\Book\Domain\BookId;
use CyanBooks\Book\Domain\BookTitle;
use CyanBooks\Test\Book\Shared\TestCase;
use CyanBooks\Book\Infrastructure\InMemoryBookRepository;

final class InMemoryBookRepositoryTest extends TestCase
{
    /* @var BookRepository */
    private $repository;

    public function setUp()
    {
        $this->repository = new InMemoryBookRepository();
    }

    /** @test */
    public function itShouldSaveABook(): void
    {
        $book = new Book(
            new BookId('9'),
            new BookTitle('Conviértete en maestro del póker con Pol Colomo'),
            new Isbn('978-9-6611-5391-1')
        );

        $this->repository->save($book);

        $this->expectNotToPerformAssertions();
    }

    /** @test */
    public function itShouldNotSaveABookWithExistingId(): void
    {
        $book = new Book(
            new BookId('7'),
            new BookTitle('Un nuevo caso para: Pol Colom(b)o'),
            new Isbn('978-9-6611-5391-1')
        );

        $this->repository->save($book);

        $this->expectException(Exception::class);
        
        $this->repository->save($book);
    }

    /** @test */
    public function itShouldReturnAnExistingBook(): void
    {
        $book = new Book(
            new BookId('10'),
            new BookTitle('Pol Colomo Fundamentals'),
            new Isbn('978-9-6611-5391-1')
        );

        $this->repository->save($book);

        $this->assertSame($book, $this->repository->search($book->id()));
    }

    /** @test */
    public function itShouldNotReturnANonExistingBook(): void
    {
        $this->assertNull($this->repository->search(new BookId('1')));
    }
}
