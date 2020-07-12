<?php

declare(strict_types=1);

namespace RedRat\SharedValueObjects\Tests\Unit\ValueObject;

use PHPUnit\Framework\TestCase;
use RedRat\SharedValueObjects\Exception\ValueObject\Email\InvalidValueException;
use RedRat\SharedValueObjects\ValueObject\Email;

class EmailTest extends TestCase
{
    public function testAttributes(): void
    {
        $emailExpected = 'john@doe.com';
        $email = new Email($emailExpected);

        self::assertEquals($emailExpected, $email->getValue());
    }

    public function testConstructThrowInvalidValueException(): void
    {
        self::expectException(InvalidValueException::class);

        new Email('other');
    }

    public function testIsValid(): void
    {
        self::assertTrue(Email::isValid('john@doe.com'));
    }

    public function testIsNotValidNull(): void
    {
        self::assertFalse(Email::isValid(null));
    }

    public function testIsNotValidValue(): void
    {
        self::assertFalse(Email::isValid('john.doe.com'));
    }
}
