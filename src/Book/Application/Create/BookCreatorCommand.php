<?php declare(strict_types = 1);

namespace CyanBooks\Book\Application;

final class BookCreatorCommand
{
    private $id;
    private $title;
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
