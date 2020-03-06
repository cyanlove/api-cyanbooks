<?php declare(strict_types = 1);

namespace CyanBooks\Test\Book\Domain;

use CyanBooks\Book\Domain\Author;
use CyanBooks\Book\Domain\AuthorId;
use CyanBooks\Book\Domain\AuthorName;
use CyanBooks\Test\Book\Shared\TestCase;

final class AuthorTest extends TestCase
{
    /** @var Author */
    private $author;

    /** @var string */
    private $value;

    /** @test */
    public function itShouldReturnItsId(): void
    {
        $this->givenAnAuthorWithId('123');

        $this->whenWeAskForItsId();

        $this->thenItShouldReturn('123');
    }

    /** @test */
    public function itShouldReturnItsName(): void
    {
        $this->givenAnAuthorWithName('Uri Ustrell');

        $this->whenWeAskForItsName();

        $this->thenItShouldReturn('Uri Ustrell');
    }

    private function givenAnAuthorWithId(string $id): void
    {
        $this->author = $this->anAuthorWith($id);
    }

    private function givenAnAuthorWithName(string $name): void
    {
        $this->author = $this->anAuthorWith(null, $name);
    }

    private function anAuthorWith(
        string $id = null,
        string $Name = null
    ): Author {
        return new Author(
            new AuthorId($id ?? '123'),
            new AuthorName($Name ?? 'Pol Colomo')
        );
    }

    private function whenWeAskForItsId(): void
    {
        $this->value = $this->author->id();
    }

    private function whenWeAskForItsName(): void
    {
        $this->value = $this->author->Name();
    }

    private function thenItShouldReturn(string $value): void
    {
        $this->assertEquals($value, (string) $this->value);
    }
}
