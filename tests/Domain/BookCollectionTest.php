<?php declare(strict_types = 1);

namespace CyanBooks\Test\Book\Domain;

use TypeError;
use CyanBooks\Book\Domain\Book;
use CyanBooks\Book\Domain\Isbn;
use CyanBooks\Book\Domain\BookId;
use CyanBooks\Book\Domain\BookTitle;
use CyanBooks\Book\Domain\BookCollection;
use CyanBooks\Book\Domain\DuplicatedBook;
use CyanBooks\Test\Book\Shared\TestCase;

final class BookCollectionTest extends TestCase
{
    /** @var BookCollection */
    private $collection;

    /** @var array */
    private $elements;

    private $value;

    /** @test */
    public function itShouldReturnAllBooks(): void
    {
        $books = [
            $this->aBookWithId('1'),
            $this->aBookWithId('2'),
            $this->aBookWithId('3'),
            $this->aBookWithId('4'),
        ];

        $this->givenACollectionWith(...$books);

        $this->whenWeAskForItsElements();

        $this->thenItShouldReturn($books);
    }

    /** @test */
    public function itShouldThrowAnExceptionWhenAddingAnExistingBook(): void
    {
        $book = $this->aBookWithId('1');

        $this->givenTheElements([$book, $book]);

        $this->thenItShouldThrow(DuplicatedBook::class);
        
        $this->whenWeAddThemToTheCollection();
    }

    /** @test */
    public function itShouldThrowAnExceptionWhenAddingSomethingThatIsNotaBookWithId(): void
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

    private function aBookWithId(string $id): Book
    {
        return new Book(
            new BookId($id),
            new BookTitle('whatever'),
            new Isbn('978-9-6611-5391-1')
        );
    }
}
