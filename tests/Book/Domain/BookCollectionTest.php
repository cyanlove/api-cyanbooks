<?php declare(strict_types = 1);

namespace CyanBooks\Test\Book\Domain;

use CyanBooks\Book\Domain\Book;
use CyanBooks\Book\Domain\Isbn;
use CyanBooks\Book\Domain\BookId;
use CyanBooks\Book\Domain\BookTitle;
use CyanBooks\Book\Domain\BookCollection;
use CyanBooks\Book\Domain\DuplicatedBook;
use CyanBooks\Book\Domain\AuthorIdCollection;
use CyanBooks\Shared\Author\Domain\AuthorId;
use CyanBooks\Test\Shared\TestCase;
use TypeError;

final class BookCollectionTest extends TestCase
{
    const VALID_ISBN = '978-9-6611-5391-1';

    /** @var BookCollection */
    private $collection;

    /** @var array */
    private $elements;

    private $value;

    /** @test */
    public function itShouldReturnAllBooks(): void
    {
        $books = [
            $this->aBook(),
            $this->aBook(),
            $this->aBook(),
            $this->aBook(),
        ];

        $this->givenACollectionWith(...$books);

        $this->whenWeAskForItsElements();

        $this->thenItShouldReturn($books);
    }

    /** @test */
    public function itShouldThrowAnExceptionWhenAddingAnExistingBook(): void
    {
        $book = $this->aBook();

        $this->givenTheElements([$book, $book]);

        $this->thenItShouldThrow(DuplicatedBook::class);
        
        $this->whenWeAddThemToTheCollection();
    }

    /** @test */
    public function itShouldThrowAnExceptionWhenAddingSomethingThatIsNotABookWithId(): void
    {
        $this->givenTheElements(['foo']);

        $this->thenItShouldThrow(TypeError::class);
        
        $this->whenWeAddThemToTheCollection();
    }

    private function givenACollectionWith(Book ...$books): void
    {
        $this->setCollection($books);
    }

    private function givenTheElements(array $elements): void
    {
        $this->elements = $elements;
    }

    private function whenWeAskForItsElements(): void
    {
        $this->value = $this->collection->toArray();
    }

    private function whenWeAddThemToTheCollection(): void
    {
        $this->setCollection($this->elements);
    }

    private function thenItShouldReturn($value): void
    {
        $this->assertEquals(
            $value,
            $this->value
        );
    }

    private function thenItShouldThrow(string $exception): void
    {
        $this->expectException($exception);
    }

    private function setCollection(array $elements): void
    {
        $this->collection = BookCollection::create(...$elements);
    }

    private function aBook(): Book
    {
        return new Book(
            BookId::random(),
            new BookTitle('whatever'),
            new Isbn(self::VALID_ISBN),
            AuthorIdCollection::create(
                AuthorId::random()
            )
        );
    }
}
