<?php

declare(strict_types=1);

namespace RedRat\SharedValueObjects\Tests\Unit\ValueObject\Brazil\Telecom;

use PHPUnit\Framework\TestCase;
use RedRat\SharedValueObjects\Exception\ValueObject\Brazil\Telecom\Landline\InvalidNumberException;
use RedRat\SharedValueObjects\ValueObject\Brazil\Telecom\Landline;

class LandlineTest extends TestCase
{
    public function testAttributes(): void
    {
        $landlineNumberExpected = '28101123';
        $landlineNumberMaskedExpected = '2810-1123';
        $landline = new Landline($landlineNumberExpected);

        self::assertEquals($landlineNumberExpected, $landline->getNumber());
        self::assertEquals($landlineNumberMaskedExpected, $landline->getNumberMasked());
    }

    public function testConstructThrowInvalidNumberException(): void
    {
        self::expectException(InvalidNumberException::class);

        new Landline('other');
    }

    public function testIsValid(): void
    {
        self::assertTrue(Landline::isValid('28101123'));
    }

    public function testIsNotValidNull(): void
    {
        self::assertFalse(Landline::isValid(null));
    }

    public function testIsNotValidNumber(): void
    {
        self::assertFalse(Landline::isValid('78101123'));
    }
}
