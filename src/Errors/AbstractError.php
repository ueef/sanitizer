<?php

declare(strict_types=1);

namespace Ueef\Sanitizer\Errors;

use Ueef\Sanitizer\Interfaces\ErrorInterface;

abstract class AbstractError implements ErrorInterface
{
    private string $key;


    public function __construct(string $key)
    {
        $this->key = $key;
    }

    public function getKey(): string
    {
        return $this->key;
    }
}