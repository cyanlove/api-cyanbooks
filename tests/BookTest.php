<?php declare(strict_types = 1);

namespace CyanLove\CyanBooks;

use CyanLove\CyanBooks\Book;
use PHPUnit\Framework\TestCase;

final class BookTest extends TestCase
{
    /** @var Book */
    private $book;

    /** @var string */
    private $value;

    public function tearDown()
    {
        parent::tearDown();

        $this->book = null;
        $this->value = null;
    }

    /** @test */
    public function itShouldReturnItsId()
    {
        $this->givenABookWith('123', 'Moby Dick', '978-9-6611-5391-1');

        $this->whenWeAskForItsId();

        $this->thenItShouldReturn('123');
    }

    /** @test */
    public function itShouldReturnItsTitle()
    {
        $this->givenABookWith('123', 'Moby Dick', '978-9-6611-5391-1');

        $this->whenWeAskForItsTitle();

        $this->thenItShouldReturn('Moby Dick');
    }

    /** @test */
    public function itShouldReturnItsIsbn()
    {
        $this->givenABookWith('123', 'Moby Dick', '978-9-6611-5391-1');

        $this->whenWeAskForItsIsbn();

        $this->thenItShouldReturn('978-9-6611-5391-1');
    }

    private function givenABookWith(string $id, string $title, string $isbn)
    {
        $this->book = new Book($id, $title, $isbn);
    }

    private function whenWeAskForItsId()
    {
        $this->value = $this->book->id();
    }

    private function whenWeAskForItsTitle()
    {
        $this->value = $this->book->title();
    }

    private function whenWeAskForItsIsbn()
    {
        $this->value = $this->book->isbn();
    }

    private function thenItShouldReturn(string $value)
    {
        $this->assertEquals($value, $this->value);
    }
}
