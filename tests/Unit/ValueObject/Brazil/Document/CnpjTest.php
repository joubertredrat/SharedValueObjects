<?php

declare(strict_types=1);

namespace RedRat\SharedValueObjects\Tests\Unit\ValueObject\Brazil\Document;

use PHPUnit\Framework\TestCase;
use RedRat\SharedValueObjects\Exception\ValueObject\Brazil\Document\Cnpj\InvalidNumberException;
use RedRat\SharedValueObjects\ValueObject\Brazil\Document\Cnpj;

class CnpjTest extends TestCase
{
    public function testAttributes(): void
    {
        $cnpjNumberExpected = '07089078000173';
        $cnpjNumberMaskedExpected = '07.089.078/0001-73';
        $cnpj = new Cnpj($cnpjNumberExpected);

        self::assertEquals($cnpjNumberExpected, $cnpj->getNumber());
        self::assertEquals($cnpjNumberMaskedExpected, $cnpj->getNumberMasked());
    }

    public function testAttributesNewFormat(): void
    {
        $cnpjNumberExpected = 'ABCDEFGIHIJK56';
        $cnpjNumberMaskedExpected = 'AB.CDE.FGI/HIJK-56';
        $cnpj = new Cnpj($cnpjNumberExpected);

        self::assertEquals($cnpjNumberExpected, $cnpj->getNumber());
        self::assertEquals($cnpjNumberMaskedExpected, $cnpj->getNumberMasked());
    }

    public function testConstructThrowInvalidNumberException(): void
    {
        self::expectException(InvalidNumberException::class);

        new Cnpj('other');
    }

    public function testIsValid(): void
    {
        self::assertTrue(Cnpj::isValid('07089078000173'));
    }

    public function testIsNotValidNull(): void
    {
        self::assertFalse(Cnpj::isValid(null));
    }

    public function testIsNotValidLength(): void
    {
        self::assertFalse(Cnpj::isValid('13898463699'));
    }

    public function testIsNotValidRepeatedNumber(): void
    {
        self::assertFalse(Cnpj::isValid('11111111111111'));
    }

    public function testIsNotValidMathCheckDigit1(): void
    {
        self::assertFalse(Cnpj::isValid('07089078000273'));
    }

    public function testIsNotValidMathCheckDigit2(): void
    {
        self::assertFalse(Cnpj::isValid('07089078000174'));
    }
}
