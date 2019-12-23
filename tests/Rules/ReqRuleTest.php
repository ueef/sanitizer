<?php

declare(strict_types=1);

namespace Ueef\Sanitizer\Tests\Rules;

use Ueef\Sanitizer\Errors\UndefinedKeyError;
use Ueef\Sanitizer\Exceptions\SanitizingException;
use Ueef\Sanitizer\Rules\ReqRule;
use Ueef\Sanitizer\Tests\AbstractTest;

class ReqRuleTest extends AbstractTest
{
    public function testSanitize()
    {
        $values = $this->makeRandomBoolArray(8, 16);
        $this->assignRandomStringKeys($values);
        $origValues = $values;

        $keys = array_keys($values);
        shuffle($keys);
        $keys = array_slice($keys, 0, intval(count($values) / 2));

        $rule = new ReqRule(...$keys);
        $rule->sanitize($values);
        $this->assertEquals($values, $origValues);

        foreach ($keys as $key) {
            unset($values[$key]);
        }

        try {
            $rule->sanitize($values);
        } catch (SanitizingException $e) {
            $errorKeys = [];
            foreach ($e->getErrors() as $error) {
                $this->assertInstanceOf(UndefinedKeyError::class, $error);
                $errorKeys[] = $error->getKey();
            }

            $this->assertEquals($keys, $errorKeys);
        }
    }
}