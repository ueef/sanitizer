<?php

declare(strict_types=1);

namespace Ueef\Sanitizer\Tests\Errors;

use PHPUnit\Framework\TestCase;
use Ueef\Sanitizer\Errors\InvalidFormatError;
use Ueef\Sanitizer\Interfaces\ErrorInterface;

class InvalidFormatErrorTest extends TestCase
{
    public function testGetKey()
    {
        $key = $this->makeKey();
        $error = $this->makeError($key);
        $this->assertEquals($error->getKey(), $key);
    }

    private function makeKey(): string
    {
        return random_bytes(random_int(8, 32));
    }

    private function makeError(string $key): InvalidFormatError
    {
        return new InvalidFormatError($key);
    }

    public function testGetType()
    {
        $key = $this->makeKey();
        $error = $this->makeError($key);
        $this->assertEquals(ErrorInterface::TYPE_INVALID_FORMAT, $error->getType());
    }

    public function testGetMessage()
    {
        $key = $this->makeKey();
        $error = $this->makeError($key);
        $this->assertEquals("the value of the key \"{$key}\" has an invalid format", $error->getMessage());
    }
}