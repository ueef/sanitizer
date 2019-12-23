<?php

declare(strict_types=1);

namespace Ueef\Sanitizer\Tests\Errors;

use PHPUnit\Framework\TestCase;
use Ueef\Sanitizer\Errors\InvalidTypeError;
use Ueef\Sanitizer\Interfaces\ErrorInterface;

class InvalidTypeErrorTest extends TestCase
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

    private function makeError(string $key): InvalidTypeError
    {
        return new InvalidTypeError($key);
    }

    public function testGetType()
    {
        $key = $this->makeKey();
        $error = $this->makeError($key);
        $this->assertEquals(ErrorInterface::TYPE_INVALID_TYPE, $error->getType());
    }

    public function testGetMessage()
    {
        $key = $this->makeKey();
        $error = $this->makeError($key);
        $this->assertEquals("the value of the key \"{$key}\" has an invalid type", $error->getMessage());
    }
}