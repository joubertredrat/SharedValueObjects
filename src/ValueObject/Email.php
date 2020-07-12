<?php

declare(strict_types=1);

namespace RedRat\SharedValueObjects\ValueObject;

use RedRat\SharedValueObjects\Exception\ValueObject\Email\InvalidValueException;

use function filter_var;

final class Email
{
    private string $value;

    public function __construct(string $value)
    {
        if (!self::isValid($value)) {
            throw InvalidValueException::handle($value);
        }

        $this->value = $value;
    }

    public function getValue(): string
    {
        return $this->value;
    }

    public static function isValid(?string $value): bool
    {
        return false !== filter_var($value, FILTER_VALIDATE_EMAIL);
    }
}
