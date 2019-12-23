<?php

declare(strict_types=1);

namespace Ueef\Sanitizer\Errors;

class InvalidFormatError extends AbstractError
{
    public function getType(): int
    {
        return self::TYPE_INVALID_FORMAT;
    }

    public function getMessage(): string
    {
        return "the value of the key \"{$this->getKey()}\" has an invalid format";
    }
}