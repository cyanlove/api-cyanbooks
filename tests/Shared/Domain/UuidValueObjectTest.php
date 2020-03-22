<?php declare(strict_types = 1);

namespace CyanBooks\Test\Shared\Domain;

use CyanBooks\Test\Shared\TestCase;
use CyanBooks\Shared\Domain\UuidValueObject;
use CyanBooks\Shared\Domain\InvalidUuidValueObject;

final class AuthorIdCollectionTest extends TestCase
{
    const VALID_UUID = '550e8400-e29b-41d4-a716-446655440000';
    const INVALID_UUID = 'olakease';

    /** @test */
    public function itShouldCreateAValidInstanceFromAValidAUuid(): void
    {
        $class = $this->class(self::VALID_UUID);

        $this->assertInstanceOf(UuidValueObject::class, $class);
        $this->assertEquals(self::VALID_UUID, (string) $class);
    }

    /** @test */
    public function itShouldThrowAnExceptionWhenCreatingAnInstanceFromANonValidAUuid(): void
    {
        $this->expectException(InvalidUuidValueObject::class);
        $this->expectExceptionMessage('The uuid <' . self::INVALID_UUID . '> does not match the expected format');

        $this->class(self::INVALID_UUID);
    }

    /** @test */
    public function itShouldGenerateANewValidInstanceWithARandomUuid(): void
    {
        $class = $this->class(self::VALID_UUID);

        $random = $class::random();

        $this->assertInstanceOf(UuidValueObject::class, $random);
        $this->assertNotEquals(self::VALID_UUID, (string) $random);
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
