<?php

declare(strict_types=1);

namespace Ueef\Sanitizer\Tests\Rules;

use Ueef\Sanitizer\Rules\FloatRule;
use Ueef\Sanitizer\Tests\AbstractTest;

class FloatRuleTest extends AbstractTest
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
        $def = $this->makeRandomFloat();
        $rule = new FloatRule($key, $def);

        $values[$key] = $value;
        if (is_numeric($value)) {
            $expected = (float)$value;
        } else {
            $expected = $def;
        }

        $rule->sanitize($values);
        $this->assertEquals($expected, $values[$key]);
        $this->assertEquals($diffValues, array_diff_key($values, [$key => null]));
    }
}