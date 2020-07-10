<?php

declare(strict_types=1);

namespace RedRat\SharedValueObjects\ValueObject\Brazil\Telecom;

use function sprintf;

final class Phone implements PhoneInterface
{
    private AreaCode $areaCode;
    private PhoneNumberInterface $phoneNumber;

    public function __construct(AreaCode $areaCode, PhoneNumberInterface $phoneNumber)
    {
        $this->areaCode = $areaCode;
        $this->phoneNumber = $phoneNumber;
    }

    public function getNumber(): string
    {
        return sprintf(
            '%s%s',
            $this
                ->areaCode
                ->getNumber(),
            $this
                ->phoneNumber
                ->getNumber()
        );
    }

    public function getNumberMasked(): string
    {
        return sprintf(
            '%s %s',
            $this
                ->areaCode
                ->getNumberMasked(),
            $this
                ->phoneNumber
                ->getNumberMasked()
        );
    }
}
