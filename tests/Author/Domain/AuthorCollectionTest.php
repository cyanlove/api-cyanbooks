<?php declare(strict_types = 1);

namespace CyanBooks\Test\Author\Domain;

use CyanBooks\Author\Domain\Author;
use CyanBooks\Author\Domain\AuthorName;
use CyanBooks\Author\Domain\AuthorCollection;
use CyanBooks\Author\Domain\DuplicatedAuthor;
use CyanBooks\Shared\Author\Domain\AuthorId;
use CyanBooks\Test\Shared\TestCase;
use TypeError;

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
            $this->anAuthor(),
            $this->anAuthor(),
            $this->anAuthor(),
            $this->anAuthor(),
        ];

        $this->givenACollectionWith(...$authors);

        $this->whenWeAskForItsElements();

        $this->thenItShouldReturn($authors);
    }

    /** @test */
    public function itShouldThrowAnExceptionWhenAddingAnExistingAuthor(): void
    {
        $author = $this->anAuthor();

        $this->givenTheElements([$author, $author]);

        $this->thenItShouldThrow(DuplicatedAuthor::class);
        
        $this->whenWeAddThemToTheCollection();
    }

    /** @test */
    public function itShouldThrowAnExceptionWhenAddingSomethingThatIsNotAnAuthorId(): void
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

    private function anAuthor(): Author
    {
        return new Author(
            AuthorId::random(),
            new AuthorName('whatever')
        );
    }
}
