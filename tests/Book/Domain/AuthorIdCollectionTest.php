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

final class AuthorIdCollectionTest extends TestCase
{
    /** @var AuthorIdCollection */
    private $collection;

    /** @var array */
    private $elements;

    private $value;

    /** @test */
    public function itShouldReturnAllAuthorIds(): void
    {
        $authorIds = [
            new AuthorId('1'),
            new AuthorId('2'),
            new AuthorId('3'),
            new AuthorId('4'),
        ];

        $this->givenACollectionWith(...$authorIds);

        $this->whenWeAskForItsElements();

        $this->thenItShouldReturn($authorIds);
    }

    /** @test */
    public function itShouldRemoveDuplicatedAuthorIds(): void
    {
        $authorId = new AuthorId('1');

        $this->givenACollectionWith($authorId, $authorId);

        $this->whenWeAskForItsElements();
        
        $this->thenItShouldReturn([$authorId]);
    }

    /** @test */
    public function itShouldThrowAnExceptionWhenAddingSomethingThatIsNotAnAuthorId(): void
    {
        $this->givenTheElements(['foo']);

        $this->thenItShouldThrow(TypeError::class);
        
        $this->whenWeAddThemToTheCollection();
    }

    private function givenACollectionWith(AuthorId ...$authorIds): void
    {
        $this->setCollection($authorIds);
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
        $this->collection = AuthorIdCollection::create(...$elements);
    }
}
