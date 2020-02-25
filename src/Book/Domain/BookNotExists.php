<?php declare(strict_types = 1);

namespace CyanBooks\Book\Domain;

use Exception;

final class BookNotExists extends Exception
{
    public static function withId(BookId $id): self
    {
        $message = sprintf(
            'Book with Id <%s> does not exist',
            $id->value()
        );

        return new static($message);
    }
}
