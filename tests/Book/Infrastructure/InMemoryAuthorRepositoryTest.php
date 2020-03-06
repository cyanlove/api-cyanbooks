<?php declare(strict_types = 1);

namespace CyanBooks\Test\Book\Infrastructure;

use CyanBooks\Book\Domain\Author;
use CyanBooks\Book\Domain\AuthorId;
use CyanBooks\Book\Domain\AuthorName;
use CyanBooks\Test\Book\Shared\TestCase;
use CyanBooks\Book\Domain\DuplicatedAuthor;
use CyanBooks\Book\Infrastructure\InMemoryAuthorRepository;

final class InMemoryAuthorRepositoryTest extends TestCase
{
    /* @var AuthorRepository */
    private $repository;

    public function setUp()
    {
        $this->repository = new InMemoryAuthorRepository();
    }

    /** @test */
    public function itShouldSaveAnAuthor(): void
    {
        $author = new Author(
            new AuthorId('9'),
            new AuthorName('Jaco Baldrich')
        );

        $this->repository->save($author);

        $this->expectNotToPerformAssertions();
    }

    /** @test */
    public function itShouldNotSaveABookWithExistingId(): void
    {
        $author = new Author(
            new AuthorId('7'),
            new AuthorName('Uri Ustrell')
        );

        $this->repository->save($author);

        $this->expectException(DuplicatedAuthor::class);
        
        $this->repository->save($author);
    }

    /** @test */
    public function itShouldReturnAnExistingBook(): void
    {
        $author = new Author(
            new AuthorId('10'),
            new AuthorName('Pol Colomo')
        );

        $this->repository->save($author);

        $this->assertSame($author, $this->repository->search($author->id()));
    }

    /** @test */
    public function itShouldNotReturnANonExistingBook(): void
    {
        $this->assertNull($this->repository->search(new AuthorId('1')));
    }
}
