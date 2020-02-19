<?php declare(strict_types = 1);

namespace CyanBooks\Test\Book\Domain;

use CyanBooks\Book\Domain\Book;
use CyanBooks\Book\Domain\BookCollection;
use CyanBooks\Book\Domain\BookId;
use CyanBooks\Book\Domain\BookTitle;
use CyanBooks\Book\Domain\Isbn;
use PHPUnit\Framework\TestCase;
use Exception;
use TypeError;

final class BookCollectionTest extends TestCase
{
    /** @var BookCollection */
    private $collection;

    /** @var array */
    private $elements;

    private $value;

    public function tearDown()
    {
        parent::tearDown();

        $this->collection = null;
        $this->elements = null;
        $this->value = null;
    }

    /** @test */
    public function itShouldReturnAllBooks()
    {
        $books = [
            $this->randomBook(),
        ];

        $this->givenACollectionWith(...$books);

        $this->whenWeAskForItsElements();

        $this->thenItShouldReturn($books);
    }

    /** @test */
    public function itShouldThrowAnExceptionWhenAddingAnExistingBook()
    {
        $this->givenTheElements(
            [
                $this->randomBook(),
                $this->randomBook(),
            ]
        );

        $this->thenItShouldThrow(Exception::class);
        
        $this->whenWeAddThemToTheCollection();
    }

    /** @test */
    public function itShouldThrowAnExceptionWhenAddingSomethingThatIsNotABook()
    {
        $this->givenTheElements(['foo']);

        $this->thenItShouldThrow(TypeError::class);
        
        $this->whenWeAddThemToTheCollection();
    }

    private function givenACollectionWith(Book ...$books)
    {
        $this->setCollection($books);
    }

    private function givenTheElements(array $elements)
    {
        $this->elements = $elements;
    }

    private function whenWeAskForItsElements()
    {
        $this->value = $this->collection->toArray();
    }

    private function whenWeAddThemToTheCollection()
    {
        $this->setCollection($this->elements);
    }

    private function thenItShouldReturn($value)
    {
        $this->assertEquals(
            $value,
            $this->value
        );
    }

    private function thenItShouldThrow(string $exception)
    {
        $this->expectException($exception);
    }

    private function setCollection(array $elements)
    {
        $this->collection = BookCollection::create(...$elements);
    }

    private function randomBook(): Book
    {
        return new Book(
            new BookId('123'),
            new BookTitle('Moby Dick'),
            new Isbn('978-9-6611-5391-1')
        );
    }
}
