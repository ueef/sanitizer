<?php

declare(strict_types=1);

namespace Ueef\Sanitizer\Tests\Rules;

use Ueef\Sanitizer\Rules\StringArrayRule;
use Ueef\Sanitizer\Tests\AbstractTest;

class StringArrayRuleTest extends AbstractTest
{
    /**
     * @dataProvider dataProvider
     * @param string $key
     * @param array $values
     * @param array $diffValues
     * @param $value
     */
    public function testSanitize(string $key, array $values, array $diffValues, $value)
    {
        $def = $this->makeRandomStringArray();
        $rule = new StringArrayRule($key, $def);

        $values[$key] = $value;
        if (!is_array($value)) {
            $expected = $def;
        } else {
            $expected = $value;
        }

        foreach ($expected as $i => &$v) {
            if (is_scalar($v)) {
                $v = (string)$v;
            } else {
                unset($expected[$i]);
            }
        }

        $rule->sanitize($values);
        $this->assertEquals($expected, $values[$key]);
        $this->assertEquals($diffValues, array_diff_key($values, [$key => null]));
    }
}