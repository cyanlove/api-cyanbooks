<?php declare(strict_types = 1);

namespace CyanBooks\Book\Domain;

use Exception;

final class DuplicatedBook extends Exception
{
    public static function withId(BookId $id, string $class): self
    {
        $message = sprintf(
            'Book with Id <%s> already exists in %s',
            $id->value(),
            $class
        );

        return new static($message);
    }
}
