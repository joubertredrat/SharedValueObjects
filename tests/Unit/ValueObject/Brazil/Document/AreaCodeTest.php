<?php

declare(strict_types=1);

namespace RedRat\SharedValueObjects\Tests\Unit\ValueObject\Brazil\Document;

use PHPUnit\Framework\TestCase;
use RedRat\SharedValueObjects\Exception\ValueObject\Brazil\Telecom\AreaCode\InvalidNumberException;
use RedRat\SharedValueObjects\ValueObject\Brazil\Telecom\AreaCode;

class AreaCodeTest extends TestCase
{
    public function testAttributes(): void
    {
        $areaCodeExpected = '31';
        $areaCodeMaskedExpected = '(31)';
        $areaCode = new AreaCode($areaCodeExpected);

        self::assertEquals($areaCodeExpected, $areaCode->getNumber());
        self::assertEquals($areaCodeMaskedExpected, $areaCode->getNumberMasked());
    }

    public function testConstructThrowInvalidNumberException(): void
    {
        self::expectException(InvalidNumberException::class);

        new AreaCode('other');
    }

    public function testIsValid(): void
    {
        self::assertTrue(AreaCode::isValid('31'));
    }

    public function testIsNotValidNull(): void
    {
        self::assertFalse(AreaCode::isValid(null));
    }

    public function testIsNotValidCode(): void
    {
        self::assertFalse(AreaCode::isValid('30'));
    }
}
