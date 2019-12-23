<?php

declare(strict_types=1);

namespace Ueef\Sanitizer\Tests\Rules;

use Ueef\Sanitizer\Rules\BoolArrayRule;
use Ueef\Sanitizer\Tests\AbstractTest;

class BoolArrayRuleTest extends AbstractTest
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
        $def = $this->makeRandomBoolArray();
        $rule = new BoolArrayRule($key, $def);

        $values[$key] = $value;
        if (!is_array($value)) {
            $expected = $def;
        } else {
            $expected = $value;
        }

        foreach ($expected as $i => &$v) {
            if (null === $v) {
                unset($expected[$i]);
            } else {
                $v = (bool)$v;
            }
        }

        $rule->sanitize($values);
        $this->assertEquals($expected, $values[$key]);
        $this->assertEquals($diffValues, array_diff_key($values, [$key => null]));
    }
}