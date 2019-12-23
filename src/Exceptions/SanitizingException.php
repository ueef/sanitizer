<?php

declare(strict_types=1);

namespace Ueef\Sanitizer\Exceptions;

use Exception;
use Ueef\Sanitizer\Interfaces\ErrorInterface;
use Ueef\Sanitizer\Interfaces\SanitizerErrorInterface;

class SanitizingException extends Exception implements SanitizerErrorInterface
{
    /** @var ErrorInterface[] */
    private array $errors;


    public function __construct(ErrorInterface ...$errors)
    {
        $this->errors = $errors;
        parent::__construct($this->makeMessage(), 0, null);
    }

    private function makeMessage(): string
    {
        $messages = "";
        foreach ($this->errors as $error) {
            $messages .= "\n" . $error->getMessage();
        }

        return "errors occurred while sanitizing:" . $messages;
    }

    /**
     * @return ErrorInterface[]
     */
    public function getErrors(): array
    {
        return $this->errors;
    }
}