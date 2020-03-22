<?php declare(strict_types = 1);

namespace CyanBooks\Test\Shared\Domain;

use CyanBooks\Test\Shared\TestCase;
use CyanBooks\Shared\Domain\UuidValueObject;
use CyanBooks\Shared\Domain\InvalidUuidValueObject;

final class AuthorIdCollectionTest extends TestCase
{
    /** @test */
    public function itShouldCreateAValidInstanceFromAValidAUuid()
    {
        $class = $this->class('550e8400-e29b-41d4-a716-446655440000');

        $this->assertInstanceOf(UuidValueObject::class, $class);
        $this->assertEquals('550e8400-e29b-41d4-a716-446655440000', (string) $class);
    }

    /** @test */
    public function itShouldThrowAnExceptionWhenCreatingAnInstanceFromANonValidAUuid()
    {
        $this->expectException(InvalidUuidValueObject::class);
        $this->expectExceptionMessage('The uuid <olakease> does not match the expected format');

        $this->class('olakease');
    }

    /** @test */
    public function itShouldGenerateANewValidInstanceWithARandomUuid()
    {
        $class = $this->class('550e8400-e29b-41d4-a716-446655440000');

        $random = $class::random();

        $this->assertInstanceOf(UuidValueObject::class, $random);
        $this->assertNotEquals('550e8400-e29b-41d4-a716-446655440000', (string) $random);
    }

    private function class(string $uuid): UuidValueObject
    {
        return new class($uuid) extends UuidValueObject {
            protected function exception(): InvalidUuidValueObject
            {
                return new class extends InvalidUuidValueObject {
                    protected static function message(string $value): string
                    {
                        return sprintf(
                            'The uuid <%s> does not match the expected format',
                            $value
                        );
                    }
                };
            }
        };
    }
}
