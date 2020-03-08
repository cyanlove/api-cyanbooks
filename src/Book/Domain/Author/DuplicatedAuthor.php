<?php declare(strict_types = 1);

namespace CyanBooks\Book\Domain\Author;

use Exception;

final class DuplicatedAuthor extends Exception
{
    public static function withId(AuthorId $id, string $class): self
    {
        $message = sprintf(
            'Author with Id <%s> already exists in %s',
            $id->value(),
            $class
        );

        return new static($message);
    }
}
