<?php declare(strict_types = 1);

namespace CyanBooks\Book\Domain;

interface BookRepository
{
    public function save(Book $book): void;

    public function search(BookId $id): ?Book;
}
