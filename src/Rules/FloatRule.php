<?php

declare(strict_types=1);

namespace Ueef\Sanitizer\Rules;

use Ueef\Sanitizer\Interfaces\RuleInterface;

class FloatRule implements RuleInterface
{
    private string $key;
    private float  $default;

    public function __construct(string $key, float $default = 0)
    {
        $this->key = $key;
        $this->default = $default;
    }

    public function sanitize(&$values): void
    {
        $value = &$values[$this->key];
        if (is_numeric($value)) {
            $value = (float)$value;
        } else {
            $value = $this->default;
        }
    }
}