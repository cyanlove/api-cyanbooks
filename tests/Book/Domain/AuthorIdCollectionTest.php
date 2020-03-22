<?php declare(strict_types = 1);

namespace CyanBooks\Test\Book\Domain;

use CyanBooks\Shared\Author\Domain\AuthorId;
use CyanBooks\Book\Domain\AuthorIdCollection;
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
            AuthorId::random(),
            AuthorId::random(),
            AuthorId::random(),
            AuthorId::random(),
        ];

        $this->givenACollectionWith(...$authorIds);

        $this->whenWeAskForItsElements();

        $this->thenItShouldReturn($authorIds);
    }

    /** @test */
    public function itShouldRemoveDuplicatedAuthorIds(): void
    {
        $authorId = AuthorId::random();

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
