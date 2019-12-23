<?php

declare(strict_types=1);

namespace Ueef\Sanitizer\Interfaces;

interface RuleInterface
{
    public function sanitize(array &$values): void;
}