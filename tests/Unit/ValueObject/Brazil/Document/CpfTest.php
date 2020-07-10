<?php

declare(strict_types=1);

namespace RedRat\SharedValueObjects\Tests\Unit\ValueObject\Brazil\Document;

use PHPUnit\Framework\TestCase;
use RedRat\SharedValueObjects\Exception\ValueObject\Brazil\Document\Cpf\InvalidNumberException;
use RedRat\SharedValueObjects\ValueObject\Brazil\Document\Cpf;

class CpfTest extends TestCase
{
    public function testAttributes(): void
    {
        $cpfNumberExpected = '13898463699';
        $cpfNumberMaskedExpected = '138.984.636-99';
        $cpf = new Cpf('13898463699');

        self::assertEquals($cpfNumberExpected, $cpf->getNumber());
        self::assertEquals($cpfNumberMaskedExpected, $cpf->getNumberMasked());
    }

    public function testConstructThrowInvalidNumberException(): void
    {
        self::expectException(InvalidNumberException::class);

        new Cpf('other');
    }

    public function testIsValid(): void
    {
        self::assertTrue(Cpf::isValid('13898463699'));
    }

    public function testIsNotValidNull(): void
    {
        self::assertFalse(Cpf::isValid(null));
    }

    public function testIsNotValidLength(): void
    {
        self::assertFalse(Cpf::isValid('07089078000173'));
    }

    public function testIsNotValidRepeatedNumber(): void
    {
        self::assertFalse(Cpf::isValid('11111111111'));
    }

    public function testIsNotValidMathCheckDigit1(): void
    {
        self::assertFalse(Cpf::isValid('13898463599'));
    }

    public function testIsNotValidMathCheckDigit2(): void
    {
        self::assertFalse(Cpf::isValid('13898463698'));
    }
}
