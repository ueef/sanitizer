<?php

declare(strict_types=1);

namespace Ueef\Sanitizer\Tests\Errors;

use PHPUnit\Framework\TestCase;
use Ueef\Sanitizer\Errors\UndefinedKeyError;
use Ueef\Sanitizer\Interfaces\ErrorInterface;

class UndefinedKeyErrorTest extends TestCase
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

    private function makeError(string $key): UndefinedKeyError
    {
        return new UndefinedKeyError($key);
    }

    public function testGetType()
    {
        $key = $this->makeKey();
        $error = $this->makeError($key);
        $this->assertEquals(ErrorInterface::TYPE_UNDEFINED, $error->getType());
    }

    public function testGetMessage()
    {
        $key = $this->makeKey();
        $error = $this->makeError($key);
        $this->assertEquals("the key \"{$key}\" is undefined", $error->getMessage());
    }
}