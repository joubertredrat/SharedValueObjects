<?php

declare(strict_types=1);

namespace RedRat\SharedValueObjects\ValueObject\Brazil\Telecom;

interface PhoneInterface
{
    public function getNumber(): string;

    public function getNumberMasked(): string;
}
