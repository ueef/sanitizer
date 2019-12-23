<?php

declare(strict_types=1);

namespace Ueef\Sanitizer\Tests\Rules;

use Ueef\Sanitizer\Rules\BoolRule;
use Ueef\Sanitizer\Tests\AbstractTest;

class BoolRuleTest extends AbstractTest
{
    /**
     * @dataProvider dataProvider
     * @param string $key
     * @param array $values
     * @param array $diffValues
     * @param mixed $value
     */
    public function testSanitize(string $key, array $values, array $diffValues, $value)
    {
        $def = $this->makeRandomBool();
        $rule = new BoolRule($key, $def);

        $values[$key] = $value;
        if (null === $value) {
            $expected = $def;
        } else {
            $expected = (bool)$value;
        }

        $rule->sanitize($values);
        $this->assertEquals($expected, $values[$key]);
        $this->assertEquals($diffValues, array_diff_key($values, [$key => null]));
    }
}