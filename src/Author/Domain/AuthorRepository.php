<?php declare(strict_types = 1);

namespace CyanBooks\Author\Domain;

use CyanBooks\Shared\Author\Domain\AuthorId;

interface AuthorRepository
{
    public function save(Author $book): void;

    public function search(AuthorId $id): ?Author;
}
