<?php

declare(strict_types=1);

namespace Ueef\Sanitizer\Interfaces;

interface ErrorInterface
{
    const TYPE_UNDEFINED = 1;
    const TYPE_INVALID_TYPE = 2;
    const TYPE_INVALID_FORMAT = 3;

    public function getKey(): string;

    public function getType(): int;

    public function getMessage(): string;
}