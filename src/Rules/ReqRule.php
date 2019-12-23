<?php

declare(strict_types=1);

namespace Ueef\Sanitizer\Rules;

use Ueef\Sanitizer\Errors\UndefinedKeyError;
use Ueef\Sanitizer\Exceptions\SanitizingException;
use Ueef\Sanitizer\Interfaces\RuleInterface;

class ReqRule implements RuleInterface
{
    /** @var array */
    private array $keys;


    public function __construct(string ...$keys)
    {
        $this->keys = $keys;
    }

    public function sanitize(&$values): void
    {
        $errors = [];
        foreach ($this->keys as $key) {
            if (!isset($values[$key])) {
                $errors[] = new UndefinedKeyError($key);
            }
        }

        if ($errors) {
            throw new SanitizingException(...$errors);
        }
    }
}