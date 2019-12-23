<?php

declare(strict_types=1);

namespace Ueef\Sanitizer\Tests;

use PHPUnit\Framework\TestCase;

abstract class AbstractTest extends TestCase
{
    public function dataProvider(): array
    {
        $data = [
            null,
            $this->makeRandomInt(-PHP_INT_MAX, PHP_INT_MAX),
            $this->makeRandomInt(0, PHP_INT_MAX),
            $this->makeRandomInt(-PHP_INT_MAX, 0),
            $this->makeRandomBool(),
            $this->makeRandomFloat(),
            $this->makeRandomString(),
            [],
            $this->makeRandomArray(8),
            $this->makeRandomIntArray(8),
            $this->makeRandomBoolArray(8),
            $this->makeRandomFloatArray(8),
            $this->makeRandomStringArray(8),
            (object)[],
        ];

        $a = $this->makeRandomArray(8);
        $this->assignRandomMixedKeys($a);
        $data[] = (object)$a;

        $a = $this->makeRandomIntArray(8);
        $this->assignRandomMixedKeys($a);
        $data[] = (object)$a;

        $a = $this->makeRandomBoolArray(8);
        $this->assignRandomMixedKeys($a);
        $data[] = (object)$a;

        $a = $this->makeRandomFloatArray(8);
        $this->assignRandomMixedKeys($a);
        $data[] = (object)$a;

        $a = $this->makeRandomStringArray(8);
        $this->assignRandomMixedKeys($a);
        $data[] = (object)$a;

        $key = $this->makeRandomString();
        $values = $this->makeRandomArray(16, 64);
        $this->assignRandomStringKeys($values);
        $diffValues = $values;

        foreach ($data as $i => $value) {
            $data[$i] = [$key, $values, $diffValues, $value];
        }

        return $data;
    }

    protected function makeRandomInt(int $min = -PHP_INT_MAX, int $max = PHP_INT_MAX): int
    {
        return random_int($min, $max);
    }

    protected function makeRandomBool(): bool
    {
        return (bool)$this->makeRandomInt(0, 1);
    }

    protected function makeRandomFloat(int $min = -PHP_INT_MAX, int $max = PHP_INT_MAX): float
    {


        return $this->makeRandomInt($min, $max) + (1 / $this->makeRandomInt(1));
    }

    protected function makeRandomString(int $minLength = 16, int $maxLength = 32, string $alphabet = " !\"#$%&'()*+,-./0123456789:;<=>?@ABCDEFGHIJKLMNOPQRSTUVWXYZ[\]^_`abcdefghijklmnopqrstuvwxyz{|}~юабцдефгхийклмнопярстужвьызшэщчъЮАБЦДЕФГХИЙКЛМНОПЯРСТУЖВЬЫЗШЭЩЧЪ")
    {
        $length = random_int($minLength, $maxLength);
        $alphabetLength = mb_strlen($alphabet);

        $s = "";
        for ($i = 0; $i < $length; $i++) {
            $s .= mb_substr($alphabet, $this->makeRandomInt(0, $alphabetLength - 1), 1);
        }

        return $s;
    }

    protected function makeRandomArray(int $minLength = 0, int $maxLength = 16): array
    {
        $length = random_int($minLength, $maxLength);

        $a = [];
        for ($i = 0; $i < $length; $i++) {
            switch ($this->makeRandomInt(0, 8)) {
                case 0:
                    $a[] = $this->makeRandomInt();
                    break;
                case 1:
                    $a[] = $this->makeRandomBool();
                    break;
                case 2:
                    $a[] = $this->makeRandomFloat();
                    break;
                case 3:
                    $a[] = $this->makeRandomString();
                    break;
                case 4:
                    $a[] = $this->makeRandomIntArray();
                    break;
                case 5:
                    $a[] = $this->makeRandomBoolArray();
                    break;
                case 6:
                    $a[] = $this->makeRandomFloatArray();
                    break;
                case 7:
                    $a[] = $this->makeRandomStringArray();
                    break;
                case 8:
                    $a[] = null;
                    break;
            }
        }

        return $a;
    }

    protected function makeRandomIntArray(int $minLength = 0, int $maxLength = 16): array
    {
        $length = random_int($minLength, $maxLength);

        $a = [];
        for ($i = 0; $i < $length; $i++) {
            $a[] = $this->makeRandomInt();
        }

        return $a;
    }

    protected function makeRandomBoolArray(int $minLength = 0, int $maxLength = 16): array
    {
        $length = random_int($minLength, $maxLength);

        $a = [];
        for ($i = 0; $i < $length; $i++) {
            $a[] = $this->makeRandomBool();
        }

        return $a;
    }

    protected function makeRandomFloatArray(int $minLength = 0, int $maxLength = 16): array
    {
        $length = random_int($minLength, $maxLength);

        $a = [];
        for ($i = 0; $i < $length; $i++) {
            $a[] = $this->makeRandomFloat();
        }

        return $a;
    }

    protected function makeRandomStringArray(int $minLength = 0, int $maxLength = 16): array
    {
        $length = random_int($minLength, $maxLength);

        $a = [];
        for ($i = 0; $i < $length; $i++) {
            $a[] = $this->makeRandomString();
        }

        return $a;
    }

    protected function assignRandomMixedKeys(array &$a): void
    {
        $length = random_int(1, count($a));
        $keys = $this->makeRandomStringArray($length, $length);
        $length = count($a) - $length;
        $keys = array_merge($keys, $this->makeRandomIntArray($length, $length));
        shuffle($keys);
        $a = array_combine($keys, $a);
    }

    protected function assignRandomStringKeys(array &$a): void
    {
        $length = count($a);
        $a = array_combine($this->makeRandomStringArray($length, $length), $a);
    }

    protected function getRandomArrayKey(array $a)
    {
        return array_keys($a)[random_int(0, count($a) - 1)];
    }

    protected function assignRandomIntKeys(array &$a): void
    {
        $length = count($a);
        $a = array_combine($this->makeRandomIntArray($length, $length), $a);
    }
}