<?php
declare(strict_types=1);

namespace Ueef\Sanitizer\Interfaces;

use Throwable;

interface ValidationErrorInterface extends Throwable
{
    public function getKey(): string;
    public function getRule(): string;
}