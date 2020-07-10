<?php

declare(strict_types=1);

namespace RedRat\SharedValueObjects\ValueObject\Brazil\Document;

use RedRat\SharedValueObjects\Exception\ValueObject\Brazil\Document\Cpf\InvalidNumberException;

use function array_sum;
use function filter_var;
use function is_null;
use function preg_replace;
use function sprintf;
use function strlen;

final class Cpf
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
            '%s.%s.%s-%s',
            substr($this->getNumber(), 0, 3),
            substr($this->getNumber(), 3, 3),
            substr($this->getNumber(), 6, 3),
            substr($this->getNumber(), 9, 2)
        );
    }

    public static function isValid(?string $number): bool
    {
        if (is_null($number)) {
            return false;
        }

        $number = preg_replace("/[^0-9]/", "", $number);

        if (strlen($number) != 11) {
            return false;
        }

        if (filter_var($number, FILTER_VALIDATE_REGEXP, ['options' => ['regexp' => '/(\d)\1{10}/']]) !== false) {
            return false;
        }

        $sum = [];
        for ($i = 0, $j = 10; $i < 9; $i++, $j--) {
            $sum[] = $number[$i] * $j;
        }

        $rest = array_sum($sum) % 11;
        $digit1 = $rest < 2 ? 0 : 11 - $rest;

        if ($number[9] != $digit1) {
            return false;
        }

        $sum = [];
        for ($i = 0, $j = 11; $i < 10; $i++, $j--) {
            $sum[] = $number[$i] * $j;
        }

        $rest = array_sum($sum) % 11;
        $digit2 = $rest < 2 ? 0 : 11 - $rest;

        return $number[10] == $digit2;
    }
}
