<?php

declare(strict_types=1);

namespace Ueef\Sanitizer\Tests\Rules;

use Ueef\Sanitizer\Rules\IntRule;
use Ueef\Sanitizer\Tests\AbstractTest;

class IntRuleTest extends AbstractTest
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
        $def = $this->makeRandomInt();
        $rule = new IntRule($key, $def);

        $values[$key] = $value;
        if (is_numeric($value)) {
            $expected = (int)$value;
        } else {
            $expected = $def;
        }

        $rule->sanitize($values);
        $this->assertEquals($expected, $values[$key]);
        $this->assertEquals($diffValues, array_diff_key($values, [$key => null]));
    }
}