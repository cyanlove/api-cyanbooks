<?php declare(strict_types = 1);

namespace CyanBooks\Test\Book\Domain;

use TypeError;
use CyanBooks\Book\Domain\Author\Author;
use CyanBooks\Book\Domain\Author\AuthorId;
use CyanBooks\Book\Domain\Author\AuthorName;
use CyanBooks\Test\Book\Shared\TestCase;
use CyanBooks\Book\Domain\Author\AuthorCollection;
use CyanBooks\Book\Domain\Author\DuplicatedAuthor;

final class AuthorCollectionTest extends TestCase
{
    /** @var AuthorCollection */
    private $collection;

    /** @var array */
    private $elements;

    private $value;

    /** @test */
    public function itShouldReturnAllAuthors(): void
    {
        $authors = [
            $this->anAuthorWithId('1'),
            $this->anAuthorWithId('2'),
            $this->anAuthorWithId('3'),
            $this->anAuthorWithId('4'),
        ];

        $this->givenACollectionWith(...$authors);

        $this->whenWeAskForItsElements();

        $this->thenItShouldReturn($authors);
    }

    /** @test */
    public function itShouldThrowAnExceptionWhenAddingAnExistingBook(): void
    {
        $author = $this->anAuthorWithId('1');

        $this->givenTheElements([$author, $author]);

        $this->thenItShouldThrow(DuplicatedAuthor::class);
        
        $this->whenWeAddThemToTheCollection();
    }

    /** @test */
    public function itShouldThrowAnExceptionWhenAddingSomethingThatIsNotanAuthorWithId(): void
    {
        $this->givenTheElements(['foo']);

        $this->thenItShouldThrow(TypeError::class);
        
        $this->whenWeAddThemToTheCollection();
    }

    private function givenACollectionWith(Author ...$authors): void
    {
        $this->setCollection($authors);
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
        $this->collection = AuthorCollection::create(...$elements);
    }

    private function anAuthorWithId(string $id): Author
    {
        return new Author(
            new AuthorId($id),
            new AuthorName('whatever')
        );
    }
}
