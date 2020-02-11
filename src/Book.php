<?php declare(strict_types = 1);

namespace CyanLove\CyanBooks;

final class Book
{
    /** @var string */
    private $id;

    /** @var string */
    private $title;

    /** @var string */
    private $isbn;

    public function __construct(string $id, string $title, string $isbn)
    {
        $this->id = $id;
        $this->title = $title;
        $this->isbn = $isbn;
    }

    public function id(): string
    {
        return $this->id;
    }

    public function title(): string
    {
        return $this->title;
    }

    public function isbn(): string
    {
        return $this->isbn;
    }
    
}
