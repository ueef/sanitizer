<?php

declare(strict_types=1);

namespace Ueef\Sanitizer;

use Ueef\Sanitizer\Exceptions\SanitizingException;
use Ueef\Sanitizer\Interfaces\RuleInterface;
use Ueef\Sanitizer\Interfaces\SanitizerErrorInterface;
use Ueef\Sanitizer\Interfaces\SanitizerInterface;

class Sanitizer implements SanitizerInterface
{
    /** @var RuleInterface[] */
    private array $rules;


    public function __construct(RuleInterface ...$rules)
    {
        $this->rules = $rules;
    }

    public function sanitize(array $values, RuleInterface ...$rules): array
    {
        $errors = [];
        foreach (array_merge($this->rules, $rules) as $rule) {
            try {
                $rule->sanitize($values);
            } catch (SanitizerErrorInterface $e) {
                $errors = array_merge($errors, $e->getErrors());
            }
        }

        if ($errors) {
            throw new SanitizingException(...$errors);
        }

        return $values;
    }
}