<?php declare(strict_types = 1);

namespace CyanBooks\Book\Domain;

interface AuthorRepository
{
    public function save(Author $book): void;

    public function search(AuthorId $id): ?Author;
}
