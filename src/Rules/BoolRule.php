<?php

declare(strict_types=1);

namespace Ueef\Sanitizer\Rules;

use Ueef\Sanitizer\Interfaces\RuleInterface;

class BoolRule implements RuleInterface
{
    private string $key;
    private bool   $default;


    public function __construct(string $key, bool $default = false)
    {
        $this->key = $key;
        $this->default = $default;
    }

    public function sanitize(&$values): void
    {
        $value = &$values[$this->key];
        if (null === $value) {
            $value = $this->default;
        } else {
            $value = (bool)$value;
        }
    }
}