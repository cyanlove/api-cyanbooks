<?php declare(strict_types = 1);

namespace CyanBooks\Test\Book\Infrastructure;

use CyanBooks\Book\Domain\Book;
use CyanBooks\Book\Domain\Isbn;
use CyanBooks\Book\Domain\BookId;
use CyanBooks\Book\Domain\BookTitle;
use CyanBooks\Book\Domain\DuplicatedBook;
use CyanBooks\Book\Domain\AuthorIdCollection;
use CyanBooks\Book\Infrastructure\InMemoryBookRepository;
use CyanBooks\Shared\Author\Domain\AuthorId;
use CyanBooks\Test\Shared\TestCase;

final class InMemoryBookRepositoryTest extends TestCase
{
    const VALID_ISBN = '978-9-6611-5391-1';

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
            BookId::random(),
            new BookTitle('Conviértete en maestro del póker con Pol Colomo'),
            new Isbn(self::VALID_ISBN),
            AuthorIdCollection::create(
                AuthorId::random()
            )
        );

        $this->repository->save($book);

        $this->expectNotToPerformAssertions();
    }

    /** @test */
    public function itShouldNotSaveABookWithExistingId(): void
    {
        $book = new Book(
            BookId::random(),
            new BookTitle('Un nuevo caso para: Pol Colom(b)o'),
            new Isbn(self::VALID_ISBN),
            AuthorIdCollection::create(
                AuthorId::random()
            )
        );

        $this->repository->save($book);

        $this->expectException(DuplicatedBook::class);
        
        $this->repository->save($book);
    }

    /** @test */
    public function itShouldReturnAnExistingBook(): void
    {
        $book = new Book(
            BookId::random(),
            new BookTitle('Pol Colomo Fundamentals'),
            new Isbn(self::VALID_ISBN),
            AuthorIdCollection::create(
                AuthorId::random()
            )
        );

        $this->repository->save($book);

        $this->assertSame($book, $this->repository->search($book->id()));
    }

    /** @test */
    public function itShouldNotReturnANonExistingBook(): void
    {
        $this->assertNull(
            $this->repository->search(
                BookId::random()
            )
        );
    }
}
