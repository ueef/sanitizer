<?php

declare(strict_types=1);

namespace Ueef\Sanitizer\Rules;

use Ueef\Sanitizer\Interfaces\RuleInterface;

class IntRule implements RuleInterface
{
    private string $key;
    private int    $default;

    public function __construct(string $key, int $default = 0)
    {
        $this->key = $key;
        $this->default = $default;
    }

    public function sanitize(&$values): void
    {
        $value = &$values[$this->key];
        if (is_numeric($value)) {
            $value = (int)$value;
        } else {
            $value = $this->default;
        }
    }
}