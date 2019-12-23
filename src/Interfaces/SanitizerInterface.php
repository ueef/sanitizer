<?php

declare(strict_types=1);

namespace Ueef\Sanitizer\Interfaces;

interface SanitizerInterface
{
    public function sanitize(array $values, RuleInterface ...$rules): array;
}