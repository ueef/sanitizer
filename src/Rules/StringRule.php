<?php

declare(strict_types=1);

namespace Ueef\Sanitizer\Rules;

use Ueef\Sanitizer\Interfaces\RuleInterface;

class StringRule implements RuleInterface
{
    private string $key;
    private string $default;

    public function __construct(string $key, string $default = "")
    {
        $this->key = $key;
        $this->default = $default;
    }

    public function sanitize(&$values): void
    {
        $value = &$values[$this->key];
        if (is_scalar($value)) {
            $value = (string)$value;
        } else {
            $value = $this->default;
        }
    }
}