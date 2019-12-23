<?php

declare(strict_types=1);

namespace Ueef\Sanitizer\Interfaces;

use Throwable;

interface SanitizerErrorInterface extends Throwable
{
    /**
     * @return ErrorInterface[]
     */
    public function getErrors(): array;
}