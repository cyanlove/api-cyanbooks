<?php declare(strict_types = 1);

namespace CyanBooks\Test\Book\Domain;

use CyanBooks\Book\Domain\Book;
use CyanBooks\Book\Domain\Isbn;
use CyanBooks\Book\Domain\BookId;
use CyanBooks\Book\Domain\BookTitle;
use CyanBooks\Book\Domain\AuthorIdCollection;
use CyanBooks\Shared\Author\Domain\AuthorId;
use CyanBooks\Test\Shared\TestCase;

final class BookTest extends TestCase
{
    const VALID_ISBN = '978-9-6611-5391-1';

    /** @var Book */
    private $book;

    /** @var string */
    private $value;

    /** @test */
    public function itShouldReturnItsId(): void
    {
        $bookId = (string) BookId::random();

        $this->givenABookWithId($bookId);

        $this->whenWeAskForItsId();

        $this->thenItShouldReturn($bookId);
    }

    /** @test */
    public function itShouldReturnItsTitle(): void
    {
        $this->givenABookWithTitle('¿Por qué Pol Colomo y no Juan Palomo?');

        $this->whenWeAskForItsTitle();

        $this->thenItShouldReturn('¿Por qué Pol Colomo y no Juan Palomo?');
    }

    /** @test */
    public function itShouldReturnItsIsbn(): void
    {
        $this->givenABookWithIsbn(self::VALID_ISBN);

        $this->whenWeAskForItsIsbn();

        $this->thenItShouldReturn(self::VALID_ISBN);
    }

    /** @test */
    public function itShouldReturnItsAuthors(): void
    {
        $id = (string) AuthorId::random();

        $this->givenABookWithAuthors($id);

        $this->whenWeAskForItsAuthors();

        $this->thenItShouldReturnSimilar(
            AuthorIdCollection::create(
                new AuthorId($id)
            )
        );
    }

    /** @test */
    public function itShouldAddAnAuthor(): void
    {
        $uri = (string) AuthorId::random();

        $pol = (string) AuthorId::random();

        $this->givenABookWithAuthors($uri);

        $this->whenWeAddAuthor($pol);

        $this->thenItShouldReturnSimilar(
            AuthorIdCollection::create(
                new AuthorId($uri),
                new AuthorId($pol)
            )
        );
    }

    /** @test */
    public function itShouldRemoveAnAuthor(): void
    {
        $uri = (string) AuthorId::random();

        $pol = (string) AuthorId::random();

        $this->givenABookWithAuthors($uri, $pol);

        $this->whenWeRemoveAuthor($pol);

        $this->thenItShouldReturnSimilar(
            AuthorIdCollection::create(
                new AuthorId($uri)
            )
        );
    }

    private function givenABookWithId(string $id): void
    {
        $this->book = $this->aBookWith($id);
    }

    private function givenABookWithTitle(string $title): void
    {
        $this->book = $this->aBookWith(null, $title);
    }

    private function givenABookWithIsbn(string $isbn): void
    {
        $this->book = $this->aBookWith(null, null, $isbn);
    }

    private function givenABookWithAuthors(string ...$authors): void
    {
        $authors = is_array($authors) ? $authors : [$authors];
        $this->book = $this->aBookWith(null, null, null, $authors);
    }

    private function aBookWith(
        string $id = null,
        string $title = null,
        string $isbn = null,
        array $authorIds = []
    ): Book {
        return new Book(
            new BookId($id ?? '550e8400-e29b-41d4-a716-446655440000'),
            new BookTitle($title ?? 'Cuando Pol Colomo entra en tu vida'),
            new Isbn($isbn ?? '978-9-6611-5391-1'),
            AuthorIdCollection::create(
                ...$this->aBunchOfAuthorIds($authorIds)
            )
        );
    }

    private function aBunchOfAuthorIds(array $ids): array
    {
        if (empty($ids)) {
            return [
                AuthorId::random(),
                AuthorId::random(),
                AuthorId::random(),
                AuthorId::random(),
                AuthorId::random(),
            ];
        }
        return array_map(
            function ($id) {
                return new AuthorId($id);
            },
            $ids
        );
    }

    private function whenWeAskForItsId(): void
    {
        $this->value = $this->book->id();
    }

    private function whenWeAskForItsTitle(): void
    {
        $this->value = $this->book->title();
    }

    private function whenWeAskForItsIsbn(): void
    {
        $this->value = $this->book->isbn();
    }

    private function whenWeAskForItsAuthors(): void
    {
        $this->value = $this->book->authors();
    }

    private function whenWeAddAuthor(string $author): void
    {
        $this->book->writtenBy(new AuthorId($author));
        $this->value = $this->book->authors();
    }

    private function whenWeRemoveAuthor(string $author): void
    {
        $this->book->notWrittenBy(new AuthorId($author));
        $this->value = $this->book->authors();
    }

    private function thenItShouldReturn(string $value): void
    {
        $this->assertSame($value, (string) $this->value);
    }

    private function thenItShouldReturnSimilar($value): void
    {
        $this->assertEquals($value, $this->value);
    }
}
