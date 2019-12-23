<?php
declare(strict_types=1);

namespace Ueef\Sanitizer\Tests;

use Exception;
use PHPUnit\Framework\TestCase;
use Throwable;
use Ueef\Sanitizer\Errors\InvalidFormatError;
use Ueef\Sanitizer\Errors\InvalidTypeError;
use Ueef\Sanitizer\Errors\UndefinedKeyError;
use Ueef\Sanitizer\Exceptions\SanitizingException;
use Ueef\Sanitizer\Interfaces\RuleInterface;
use Ueef\Sanitizer\Interfaces\SanitizerErrorInterface;
use Ueef\Sanitizer\Sanitizer;

class SanitizerTest extends TestCase
{
    public function testSanitize()
    {
        $values = [1, 2, 3, 4];
        $exception = new Exception();
        $invalidTypeError = new InvalidTypeError("");
        $undefinedKeyError = new UndefinedKeyError("");
        $invalidFormatError = new InvalidFormatError("");

        $callingOrder = [];
        $rule1 = $this->mockRule(function (&$values) use (&$callingOrder, $invalidTypeError) {
            $callingOrder[] = 1;
            foreach ($values as &$v) {
                $v++;
            }
        });
        $rule2 = $this->mockRule(function () use (&$callingOrder, $invalidTypeError) {
            $callingOrder[] = 2;
            throw new SanitizingException($invalidTypeError);
        });

        $rule3 = $this->mockRule(function () use (&$callingOrder, $undefinedKeyError, $invalidFormatError) {
            $callingOrder[] = 3;
            throw new SanitizingException($undefinedKeyError, $invalidFormatError);
        });

        $rule4 = $this->mockRule(function () use (&$callingOrder, $exception) {
            $callingOrder[] = 4;
            throw $exception;
        });

        $sanitizer = new Sanitizer($rule1);

        $this->assertEquals([2, 3, 4, 5], $sanitizer->sanitize($values));

        try {
            $sanitizer->sanitize($values, $rule2, $rule3);
        } catch (SanitizerErrorInterface $e) {
            $this->assertEquals([$invalidTypeError, $undefinedKeyError, $invalidFormatError], $e->getErrors());
        }

        try {
            $sanitizer->sanitize($values, $rule4);
        } catch (Throwable $e) {
            $this->assertEquals($exception, $e);
        }

        $this->assertEquals([1, 1, 2, 3, 1, 4], $callingOrder);
    }

    private function mockRule(callable $callback): RuleInterface
    {
        return new class($callback) implements RuleInterface {
            private $callback;

            public function __construct(callable &$callback)
            {
                $this->callback = &$callback;
            }

            public function sanitize(array &$values): void
            {
                ($this->callback)($values);
            }
        };
    }
}