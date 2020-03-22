<?php declare(strict_types = 1);

namespace CyanBooks\Test\Author\Domain;

use CyanBooks\Author\Domain\Author;
use CyanBooks\Author\Domain\AuthorName;
use CyanBooks\Shared\Author\Domain\AuthorId;
use CyanBooks\Test\Shared\TestCase;

final class AuthorTest extends TestCase
{
    /** @var Author */
    private $author;

    /** @var string */
    private $value;

    /** @test */
    public function itShouldReturnItsId(): void
    {
        $authorId = (string) AuthorId::random();

        $this->givenAnAuthorWithId($authorId);

        $this->whenWeAskForItsId();

        $this->thenItShouldReturn($authorId);
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
            $id ? new AuthorId($id) : AuthorId::random(),
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
