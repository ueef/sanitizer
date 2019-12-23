<?php

declare(strict_types=1);

namespace Ueef\Sanitizer\Rules;

use Ueef\Sanitizer\Interfaces\RuleInterface;

class WhitelistRule implements RuleInterface
{
    /** @var array */
    private array $keys;


    public function __construct(string ...$keys)
    {
        $this->keys = array_fill_keys($keys, null);
    }

    public function sanitize(&$values): void
    {
        $values = array_intersect_key($values, $this->keys);
    }
}