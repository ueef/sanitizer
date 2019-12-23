<?php

declare(strict_types=1);

namespace Ueef\Sanitizer\Tests\Rules;

use Ueef\Sanitizer\Rules\IntArrayRule;
use Ueef\Sanitizer\Tests\AbstractTest;

class IntArrayRuleTest extends AbstractTest
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
        $def = $this->makeRandomIntArray();
        $rule = new IntArrayRule($key, $def);

        $values[$key] = $value;
        if (!is_array($value)) {
            $expected = $def;
        } else {
            $expected = $value;
        }

        foreach ($expected as $i => &$v) {
            if (is_numeric($v)) {
                $v = (int)$v;
            } else {
                unset($expected[$i]);
            }
        }

        $rule->sanitize($values);
        $this->assertEquals($expected, $values[$key]);
        $this->assertEquals($diffValues, array_diff_key($values, [$key => null]));
    }
}