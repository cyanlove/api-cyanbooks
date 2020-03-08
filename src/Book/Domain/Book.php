<?php declare(strict_types = 1);

namespace CyanBooks\Book\Domain;

use CyanBooks\Shared\Author\Domain\AuthorId;

final class Book
{
    /** @var BookId */
    private $id;

    /** @var BookTitle */
    private $title;

    /** @var Isbn */
    private $isbn;

    /** @var AuthorIdCollection */
    private $authors;

    public function __construct(
        BookId $id,
        BookTitle $title,
        Isbn $isbn,
        AuthorIdCollection $authors
    ) {
        $this->id = $id;
        $this->title = $title;
        $this->isbn = $isbn;
        $this->authors = $authors;
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

    public function authors(): AuthorIdCollection
    {
        return $this->authors;
    }

    public function writtenBy(AuthorId $authorId): void
    {
        $this->authors = AuthorIdCollection::create(
            ...array_merge(
                $this->authors()->toArray(),
                [$authorId]
            )
        );
    }

    public function notWrittenBy(AuthorId $authorId): void
    {
        $authorIds = $this->authors()->toArray();
        $key = array_search((string) $authorId, $authorIds);
        if (null !== $key) {
            unset($authorIds[$key]);
            $this->authors = AuthorIdCollection::create(...$authorIds);
        }
    }
}
