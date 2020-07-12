<?php

declare(strict_types=1);

namespace RedRat\SharedValueObjects\Tests\Unit\ValueObject\Brazil\Telecom;

use PHPUnit\Framework\TestCase;
use RedRat\SharedValueObjects\Exception\ValueObject\Brazil\Telecom\Cellphone\InvalidNumberException;
use RedRat\SharedValueObjects\ValueObject\Brazil\Telecom\Cellphone;

class CellphoneTest extends TestCase
{
    public function testAttributes(): void
    {
        $cellphoneNumberExpected = '889864410';
        $cellphoneNumberMaskedExpected = '88986-4410';

        $cellphone = new Cellphone($cellphoneNumberExpected);

        self::assertEquals($cellphoneNumberExpected, $cellphone->getNumber());
        self::assertEquals($cellphoneNumberMaskedExpected, $cellphone->getNumberMasked());
    }

    public function testConstructThrowInvalidNumberException(): void
    {
        self::expectException(InvalidNumberException::class);

        new Cellphone('other');
    }

    public function testIsValid(): void
    {
        self::assertTrue(Cellphone::isValid('889864410'));
    }

    public function testIsNotValidNull(): void
    {
        self::assertFalse(Cellphone::isValid(null));
    }

    public function testIsNotValidNumber(): void
    {
        self::assertFalse(Cellphone::isValid('589864410'));
    }
}
