<?php declare(strict_types = 1);

namespace CyanBooks\Test\Book\Domain;

use CyanBooks\Book\Domain\Book;
use CyanBooks\Book\Domain\Isbn;
use CyanBooks\Book\Domain\BookId;
use CyanBooks\Book\Domain\BookTitle;
use CyanBooks\Book\Domain\Author\Author;
use CyanBooks\Test\Book\Shared\TestCase;
use CyanBooks\Book\Domain\Author\AuthorId;
use CyanBooks\Book\Domain\Author\AuthorName;
use CyanBooks\Book\Domain\Author\AuthorCollection;

final class BookTest extends TestCase
{
    /** @var Book */
    private $book;

    /** @var string */
    private $value;

    /** @test */
    public function itShouldReturnItsId(): void
    {
        $this->givenABookWithId('123');

        $this->whenWeAskForItsId();

        $this->thenItShouldReturn('123');
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
        $this->givenABookWithIsbn('978-9-6611-5391-1');

        $this->whenWeAskForItsIsbn();

        $this->thenItShouldReturn('978-9-6611-5391-1');
    }

    /** @test */
    public function itShouldReturnItsAuthors(): void
    {
        $author = new Author(
            new AuthorId('123'),
            new AuthorName('Uri Ustrell')
        );

        $this->givenABookWithAuthors($author);

        $this->whenWeAskForItsAuthors();

        $this->thenItShouldReturnSimilar(
            AuthorCollection::create($author)
        );
    }

    /** @test */
    public function itShouldAddAnAuthor(): void
    {
        $uri = new Author(
            new AuthorId('123'),
            new AuthorName('Uri Ustrell')
        );

        $pol = new Author(
            new AuthorId('456'),
            new AuthorName('Pol Colomo')
        );

        $this->givenABookWithAuthors($uri);

        $this->whenWeAddAuthor($pol);

        $this->thenItShouldReturnSimilar(
            AuthorCollection::create($uri, $pol)
        );
    }

    /** @test */
    public function itShouldRemoveAnAuthor(): void
    {
        $uri = new Author(
            new AuthorId('123'),
            new AuthorName('Uri Ustrell')
        );

        $pol = new Author(
            new AuthorId('456'),
            new AuthorName('Pol Colomo')
        );

        $this->givenABookWithAuthors($uri, $pol);

        $this->whenWeRemoveAuthor($pol);

        $this->thenItShouldReturnSimilar(
            AuthorCollection::create($uri)
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

    private function givenABookWithAuthors(Author ...$authors): void
    {
        $anAuthor = array_pop($authors);
        $this->book = $this->aBookWith(null, null, null, $anAuthor);
        foreach ($authors as $author) {
            if ($anAuthor == $author) {
                $this->assertFalse(true);
            }
            $this->book->writtenBy($author);
        }
    }

    private function aBookWith(
        string $id = null,
        string $title = null,
        string $isbn = null,
        Author $author = null
    ): Book {
        return new Book(
            new BookId($id ?? '123'),
            new BookTitle($title ?? 'Cuando Pol Colomo entra en tu vida'),
            new Isbn($isbn ?? '978-9-6611-5391-1'),
            $author ?? new Author(
                new AuthorId('123'),
                new AuthorName('Uri Ustrell')
            )
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

    private function whenWeAddAuthor(Author $author): void
    {
        $this->book->writtenBy($author);
        $this->value = $this->book->authors();
    }

    private function whenWeRemoveAuthor(Author $author): void
    {
        $this->book->notWrittenBy($author);
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
