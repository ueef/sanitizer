<?php

declare(strict_types=1);

namespace Ueef\Sanitizer\Tests\Rules;

use Ueef\Sanitizer\Rules\WhitelistRule;
use Ueef\Sanitizer\Tests\AbstractTest;

class WhitelistRuleTest extends AbstractTest
{
    public function testSanitize()
    {
        $values = $this->makeRandomArray(8, 16);
        $this->assignRandomStringKeys($values);
        $origValues = $values;

        $keys = array_keys($values);
        shuffle($keys);
        $keys = array_slice($keys, 0, intval(count($values) / 2));

        $rule = new WhitelistRule(...$keys);
        $rule->sanitize($values);
        $this->assertEquals($values, array_intersect_key($origValues, array_fill_keys($keys, null)));
    }
}