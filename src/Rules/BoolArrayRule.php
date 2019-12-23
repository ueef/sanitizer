<?php

declare(strict_types=1);

namespace Ueef\Sanitizer\Rules;

use Ueef\Sanitizer\Interfaces\RuleInterface;

class BoolArrayRule implements RuleInterface
{
    private string $key;
    private array  $default;


    public function __construct(string $key, array $default = [])
    {
        $this->key = $key;
        $this->default = $default;
    }

    public function sanitize(&$values): void
    {
        $value = &$values[$this->key];
        if (!is_array($value)) {
            $value = $this->default;
        }

        foreach ($value as $i => &$v) {
            if (null === $v) {
                unset($value[$i]);
            } else {
                $v = (bool)$v;
            }
        }
    }
}