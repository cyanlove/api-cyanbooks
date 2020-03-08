<?php declare(strict_types = 1);

namespace CyanBooks\Book\Application\Create;

final class BookCreatorCommand
{
    private $id;
    private $title;
    private $isbn;
    private $authorId;
    private $authorName;

    public function __construct(
        string $id,
        string $title,
        string $isbn,
        string $authorId,
        string $authorName
    ) {
        $this->id = $id;
        $this->title = $title;
        $this->isbn = $isbn;
        $this->authorId = $authorId;
        $this->authorName = $authorName;
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

    public function authorId(): string
    {
        return $this->authorId;
    }

    public function authorName(): string
    {
        return $this->authorName;
    }
}
