<?php declare(strict_types = 1);

namespace CyanBooks\Test\Book\Domain;

use CyanBooks\Book\Domain\Book;
use CyanBooks\Book\Domain\Isbn;
use CyanBooks\Book\Domain\BookId;
use CyanBooks\Book\Domain\BookTitle;
use CyanBooks\Test\Book\Shared\TestCase;

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

    private function aBookWith(
        string $id = null,
        string $title = null,
        string $isbn = null
    ): Book {
        return new Book(
            new BookId($id ?? '123'),
            new BookTitle($title ?? 'Cuando Pol Colomo entra en tu vida'),
            new Isbn($isbn ?? '978-9-6611-5391-1')
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

    private function thenItShouldReturn(string $value): void
    {
        $this->assertEquals($value, (string) $this->value);
    }
}
