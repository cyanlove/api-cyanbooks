<?php declare(strict_types = 1);

namespace CyanBooks\Test\Author\Infrastructure;

use CyanBooks\Author\Domain\Author;
use CyanBooks\Author\Domain\AuthorName;
use CyanBooks\Author\Domain\DuplicatedAuthor;
use CyanBooks\Author\Infrastructure\InMemoryAuthorRepository;
use CyanBooks\Shared\Author\Domain\AuthorId;
use CyanBooks\Test\Shared\TestCase;

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
    public function itShouldNotSaveAnAuthorWithExistingId(): void
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
    public function itShouldReturnAnExistingAuthor(): void
    {
        $author = new Author(
            new AuthorId('10'),
            new AuthorName('Pol Colomo')
        );

        $this->repository->save($author);

        $this->assertSame($author, $this->repository->search($author->id()));
    }

    /** @test */
    public function itShouldNotReturnANonExistingAuthor(): void
    {
        $this->assertNull($this->repository->search(new AuthorId('1')));
    }
}
