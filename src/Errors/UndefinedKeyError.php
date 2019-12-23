<?php

declare(strict_types=1);

namespace Ueef\Sanitizer\Errors;

class UndefinedKeyError extends AbstractError
{
    public function getType(): int
    {
        return self::TYPE_UNDEFINED;
    }

    public function getMessage(): string
    {
        return "the key \"{$this->getKey()}\" is undefined";
    }
}