<?php declare(strict_types = 1);

namespace CyanBooks\Book\Application\Create;

final class BookCreatorCommand
{
    private $id;
    private $title;
    private $isbn;
    private $authorIds;

    public function __construct(
        string $id,
        string $title,
        string $isbn,
        array $authorIds
    ) {
        $this->id = $id;
        $this->title = $title;
        $this->isbn = $isbn;
        $this->authorIds = $authorIds;
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

    public function authorIds(): array
    {
        return $this->authorIds;
    }
}
