<?php

declare(strict_types=1);

namespace RedRat\SharedValueObjects\ValueObject\Brazil\Telecom;

use RedRat\SharedValueObjects\Exception\ValueObject\Brazil\Telecom\Cellphone\InvalidNumberException;

use function is_null;
use function sprintf;
use function substr;

final class Cellphone
{
    private string $number;

    public function __construct(string $number)
    {
        if (!self::isValid($number)) {
            throw InvalidNumberException::handle($number);
        }

        $this->number = $number;
    }

    public function getNumber(): string
    {
        return $this->number;
    }

    public function getNumberMasked(): string
    {
        return sprintf(
            '%s-%s',
            substr($this->getNumber(), 0, 5),
            substr($this->getNumber(), -4)
        );
    }

    public static function isValid(?string $number): bool
    {
        if (is_null($number)) {
            return false;
        }

        return false !== filter_var(
            $number,
            FILTER_VALIDATE_REGEXP,
            ['options' => ['regexp' => '/^([6-9]{1}[\d]{8})$/']]
        );
    }
}
