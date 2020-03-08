<?php declare(strict_types = 1);

namespace CyanBooks\Book\Domain\Author;

interface AuthorRepository
{
    public function save(Author $book): void;

    public function search(AuthorId $id): ?Author;
}
