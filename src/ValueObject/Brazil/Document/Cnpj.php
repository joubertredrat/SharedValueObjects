<?php

declare(strict_types=1);

namespace RedRat\SharedValueObjects\ValueObject\Brazil\Document;

use RedRat\SharedValueObjects\Exception\ValueObject\Brazil\Document\Cnpj\InvalidNumberException;

use function array_sum;
use function filter_var;
use function is_null;
use function preg_replace;
use function sprintf;
use function strlen;
use function substr;

final class Cnpj
{
    private const ALPHA_ASCII_SUBTRACT = 48;

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
            '%s.%s.%s/%s-%s',
            substr($this->getNumber(), 0, 2),
            substr($this->getNumber(), 2, 3),
            substr($this->getNumber(), 5, 3),
            substr($this->getNumber(), 8, 4),
            substr($this->getNumber(), 12, 2)
        );
    }

    public static function isValid(?string $number): bool
    {
        if (is_null($number)) {
            return false;
        }

        $number = preg_replace('/[^A-Za-z0-9]/', '', $number);

        if (14 != strlen($number)) {
            return false;
        }

        if (false !== filter_var($number, FILTER_VALIDATE_REGEXP, ['options' => ['regexp' => '/([A-Za-z0-9])\1{13}/']])) {
            return false;
        }

        $numbers = self::convert($number);

        $sum = [];
        for ($i = 0, $j = 5; $i < 12; $i++) {
            $sum[] = $numbers[$i] * $j;
            $j = ($j == 2) ? 9 : $j - 1;
        }

        $rest = array_sum($sum) % 11;
        $digit1 = $rest < 2 ? 0 : 11 - $rest;

        if ($numbers[12] != $digit1) {
            return false;
        }

        $sum = [];
        for ($i = 0, $j = 6; $i < 13; $i++) {
            $sum[] = $numbers[$i] * $j;
            $j = ($j == 2) ? 9 : $j - 1;
        }

        $rest = array_sum($sum) % 11;
        $digit2 = $rest < 2 ? 0 : 11 - $rest;

        return $numbers[13] == $digit2;
    }

    private static function convert(string $number): array
    {
        $numbers = [];
        foreach (str_split($number) as $char) {
            $numbers[] = ctype_alpha($char) ? ord(strtoupper($char)) - self::ALPHA_ASCII_SUBTRACT : (int) $char;
        }

        return $numbers;
    }
}
