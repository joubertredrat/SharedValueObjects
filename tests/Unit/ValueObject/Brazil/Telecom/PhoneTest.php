<?php

declare(strict_types=1);

namespace RedRat\SharedValueObjects\Tests\Unit\ValueObject\Brazil\Telecom;

use PHPUnit\Framework\TestCase;
use RedRat\SharedValueObjects\ValueObject\Brazil\Telecom\AreaCode;
use RedRat\SharedValueObjects\ValueObject\Brazil\Telecom\Cellphone;
use RedRat\SharedValueObjects\ValueObject\Brazil\Telecom\Landline;
use RedRat\SharedValueObjects\ValueObject\Brazil\Telecom\Phone;

use function sprintf;

class PhoneTest extends TestCase
{
    public function testAttributes(): void
    {
        $phoneOneAreaCodeExpected = new AreaCode('31');
        $phoneOneCellphoneExpected = new Cellphone('889864410');
        $phoneOne = new Phone($phoneOneAreaCodeExpected, $phoneOneCellphoneExpected);

        $phoneTwoAreaCodeExpected = new AreaCode('31');
        $phoneTwoLandlineExpected = new Landline('28101123');
        $phoneTwo = new Phone($phoneTwoAreaCodeExpected, $phoneTwoLandlineExpected);

        self::assertEquals(
            sprintf(
                '%s%s',
                $phoneOneAreaCodeExpected->getNumber(),
                $phoneOneCellphoneExpected->getNumber()
            ),
            $phoneOne->getNumber()
        );
        self::assertEquals(
            sprintf(
                '%s %s',
                $phoneOneAreaCodeExpected->getNumberMasked(),
                $phoneOneCellphoneExpected->getNumberMasked()
            ),
            $phoneOne->getNumberMasked()
        );
        self::assertEquals(
            sprintf(
                '%s%s',
                $phoneTwoAreaCodeExpected->getNumber(),
                $phoneTwoLandlineExpected->getNumber()
            ),
            $phoneTwo->getNumber()
        );
        self::assertEquals(
            sprintf(
                '%s %s',
                $phoneTwoAreaCodeExpected->getNumberMasked(),
                $phoneTwoLandlineExpected->getNumberMasked()
            ),
            $phoneTwo->getNumberMasked()
        );
    }
}
