<?php declare(strict_types = 1);

namespace CyanBooks\Book\Domain;

final class Book
{
    /** @var BookId */
    private $id;

    /** @var BookTitle */
    private $title;

    /** @var Isbn */
    private $isbn;

    public function __construct(BookId $id, BookTitle $title, Isbn $isbn)
    {
        $this->id = $id;
        $this->title = $title;
        $this->isbn = $isbn;
    }

    public function id(): BookId
    {
        return $this->id;
    }

    public function title(): BookTitle
    {
        return $this->title;
    }

    public function isbn(): Isbn
    {
        return $this->isbn;
    }
}
