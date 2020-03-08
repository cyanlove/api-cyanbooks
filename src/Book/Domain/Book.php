<?php declare(strict_types = 1);

namespace CyanBooks\Book\Domain;

use CyanBooks\Book\Domain\Author\Author;
use CyanBooks\Book\Domain\Author\AuthorCollection;

final class Book
{
    /** @var BookId */
    private $id;

    /** @var BookTitle */
    private $title;

    /** @var Isbn */
    private $isbn;

    /** @var AuthorCollection */
    private $authors;

    public function __construct(
        BookId $id,
        BookTitle $title,
        Isbn $isbn,
        Author $author
    ) {
        $this->id = $id;
        $this->title = $title;
        $this->isbn = $isbn;
        $this->authors = AuthorCollection::create($author);
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

    public function authors(): AuthorCollection
    {
        return $this->authors;
    }

    public function writtenBy(Author $author): void
    {
        $this->authors = AuthorCollection::create(
            $author,
            ...$this->authors()->toArray()
        );
    }

    public function notWrittenBy(Author $author): void
    {
        $authors = $this->authors()->toArray();
        if (in_array($author, $authors, true)) {
            $key = array_keys($authors, $author, true);
            unset($authors[reset($key)]);
            $this->authors = AuthorCollection::create(...$authors);
        }
    }
}
