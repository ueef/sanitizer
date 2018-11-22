<?php
declare(strict_types=1);

namespace Ueef\Sanitizer\Exceptions;

class ValidationErrorException extends \Exception
{
    /** @var string */
    protected $key;

    /** @var string */
    protected $rule;


    public function __construct(string $message, string $rule, string $key)
    {
        $this->key = $key;
        $this->rule = $rule;

        parent::__construct($message);
    }

    public function getKey(): string
    {
        return $this->key;
    }

    public function getRule(): string
    {
        return $this->rule;
    }
}