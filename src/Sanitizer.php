<?php
declare(strict_types=1);

namespace Ueef\Sanitizer;

use Ueef\Sanitizer\Exceptions\ValidationErrorException;

class Sanitizer
{
    const REQ = 'req';
    const INT = 'int';
    const NAT = 'nat';
    const FLT = 'flt';
    const NUM = 'num';
    const STR = 'str';
    const BLN = 'bln';
    const ARR = 'arr';
    const ARR_INT = 'arr_int';
    const ARR_NAT = 'arr_nat';
    const ARR_FLT = 'arr_flt';
    const ARR_NUM = 'arr_num';
    const ARR_STR = 'arr_str';

    const TRM = 'trm';
    const CLR = 'clr';
    const LWR = 'lwr';

    /** @var bool */
    private $strict;


    public function __construct(bool $strict = true)
    {
        $this->strict = $strict;
    }

    public function sanitize(&$value, array $rules, string $key = '')
    {
        foreach ($rules as $rule) {
            $this->applyRule($value, $rule, $key);
        }
    }

    public function sanitizeArray(array &$data, array $rulesByKey)
    {
        $data = array_intersect_key($data, $rulesByKey);
        foreach ($rulesByKey as $key => $rules) {
            if (isset($data[$key])) {
                $value = &$data[$key];
            } else {
                $value = null;
            }
            $this->sanitize($value, $rules, $key);
            unset($value);
        }
    }

    private function applyRule(&$value, string $rule, string $key): void
    {
        switch ($rule) {
            case self::REQ:
                $this->validateReq($value, $key, $rule);
                break;
            case self::INT:
                $this->validateInt($value, $key, $rule);
                break;
            case self::NAT:
                $this->validateNat($value, $key, $rule);
                break;
            case self::FLT:
                $this->validateFlt($value, $key, $rule);
                break;
            case self::NUM:
                $this->validateNum($value, $key, $rule);
                break;
            case self::STR:
                $this->validateStr($value, $key, $rule);
                break;
            case self::BLN:
                $this->validateBln($value, $key, $rule);
                break;
            case self::ARR:
                $this->validateArr($value, $key, $rule);
                break;
            case self::ARR_INT:
                $this->validateArrInt($value, $key, $rule);
                break;
            case self::ARR_NAT:
                $this->validateArrNat($value, $key, $rule);
                break;
            case self::ARR_FLT:
                $this->validateArrFlt($value, $key, $rule);
                break;
            case self::ARR_NUM:
                $this->validateArrNum($value, $key, $rule);
                break;
            case self::ARR_STR:
                $this->validateArrStr($value, $key, $rule);
                break;
            case self::TRM:
                $this->filterTrm($value);
                break;
            case self::CLR:
                $this->filterClr($value);
                break;
            case self::LWR:
                $this->filterLwr($value);
                break;
            default:
                throw new ValidationErrorException(sprintf("rule \"%s\" is undefined", $rule), $rule, $key);
        }
    }

    private function validateReq($value, string $rule, string $key): void
    {
        if (null === $value) {
            throw new ValidationErrorException("\"%s\" is required", $rule, $key);
        }
    }

    private function validateInt($value, string $rule, string $key): void
    {
        if (null === $value || $this->isInteger($value)) {
            return;
        }

        throw new ValidationErrorException("\"%s\" is not an integer", $rule, $key);
    }

    private function validateNat($value, string $rule, string $key): void
    {
        if (null === $value || ($this->isInteger($value) && $value > 0)) {
            return;
        }

        throw new ValidationErrorException("\"%s\" is not a natural number", $rule, $key);
    }

    private function validateFlt($value, string $rule, string $key): void
    {
        if (null === $value || $this->isFloat($value)) {
            return;
        }

        throw new ValidationErrorException("\"%s\" is not a float", $rule, $key);
    }

    private function validateNum($value, string $rule, string $key): void
    {
        if (null === $value || $this->isNumeric($value)) {
            return;
        }

        throw new ValidationErrorException("\"%s\" is not a number", $rule, $key);
    }

    private function validateStr($value, string $rule, string $key): void
    {
        if (null === $value || $this->isString($value)) {
            return;
        }

        throw new ValidationErrorException("\"%s\" is not a string", $rule, $key);
    }

    private function validateBln($value, string $rule, string $key): void
    {
        if (null === $value || $this->isBool($value)) {
            return;
        }

        throw new ValidationErrorException("\"%s\" is not a boolean", $rule, $key);
    }

    private function validateArr($values, string $rule, string $key): void
    {
        if (null === $values || is_array($values)) {
            return;
        }

        throw new ValidationErrorException("\"%s\" is not an array", $rule, $key);
    }

    private function validateArrInt($values, string $rule, string $key): void
    {
        if (null === $values) {
            return;
        }

        $this->validateArr($values, $key, $rule);

        foreach ($values as $value) {
            if (!$this->isInteger($value)) {
                throw new ValidationErrorException("\"%s\" is not an array of integers", $rule, $key);
            }
        }
    }

    private function validateArrNat($values, string $rule, string $key): void
    {
        if (null === $values) {
            return;
        }

        $this->validateArr($values, $key, $rule);

        foreach ($values as $value) {
            if (!$this->isInteger($value) || $value < 1) {
                throw new ValidationErrorException("\"%s\" is not an array of natural numbers", $rule, $key);
            }
        }
    }

    private function validateArrFlt($values, string $rule, string $key): void
    {
        if (null === $values) {
            return;
        }

        $this->validateArr($values, $key, $rule);

        foreach ($values as $value) {
            if (!$this->isFloat($value)) {
                throw new ValidationErrorException("\"%s\" is not an array of floats", $rule, $key);
            }
        }
    }

    private function validateArrNum($values, string $rule, string $key): void
    {
        if (null === $values) {
            return;
        }

        $this->validateArr($values, $key, $rule);

        foreach ($values as $value) {
            if (!$this->isNumeric($value)) {
                throw new ValidationErrorException("\"%s\" is not an array of numbers", $rule, $key);
            }
        }
    }

    private function validateArrStr($values, string $rule, string $key): void
    {
        if (null === $values) {
            return;
        }

        $this->validateArr($values, $key, $rule);

        foreach ($values as $value) {
            if (!$this->isString($value)) {
                throw new ValidationErrorException("\"%s\" is not an array of strings", $rule, $key);
            }
        }
    }

    private function filterTrm(&$value): void
    {
        if (null === $value) {
            return;
        }

        if (is_array($value)) {
            $items = &$value;
        } else {
            $items = [&$value];
        }

        foreach ($items as &$item) {
            $item = preg_replace("/^\s+|\s+$/", "", $item);
        }
    }

    private function filterClr(&$value): void
    {
        if (null === $value) {
            return;
        }

        if (is_array($value)) {
            $items = &$value;
        } else {
            $items = [&$value];
        }

        foreach ($items as &$item) {
            $item = strip_tags($item);
            $item = htmlentities($item);
        }
    }

    private function filterLwr(&$value): void
    {
        if (null === $value) {
            return;
        }

        if (is_array($value)) {
            $items = &$value;
        } else {
            $items = [&$value];
        }

        foreach ($items as &$item) {
            $item = mb_convert_case($item, MB_CASE_LOWER);
        }
    }

    private function isBool(&$value): bool
    {
        if (is_bool($value)) {
            return true;
        }
        if ($this->strict) {
            return false;
        }
        $value = (bool) $value;

        return true;
    }

    private function isFloat(&$value): bool
    {
        if (is_float($value)) {
            return true;
        }
        if ($this->strict) {
            return false;
        }
        $value = (float) $value;

        return true;
    }

    private function isInteger(&$value): bool
    {
        if (is_integer($value)) {
            return true;
        }
        if ($this->strict) {
            return false;
        }
        $value = (int) $value;

        return true;
    }

    private function isNumeric(&$value): bool
    {
        return is_numeric($value);
    }

    private function isString(&$value): bool
    {
        if (is_string($value)) {
            return true;
        }
        if ($this->strict) {
            return false;
        }
        $value = (string) $value;

        return true;
    }
}