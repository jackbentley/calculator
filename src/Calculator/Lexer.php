<?php

namespace App\Calculator;

use Doctrine\Common\Lexer\AbstractLexer;

class Lexer extends AbstractLexer
{
    public const T_NUMBER = 1;

    public const T_ADDITION = 10;
    public const T_SUBTRACTION = 11;
    public const T_DIVISION = 12;
    public const T_MULTIPLICATION = 13;

    protected function getCatchablePatterns()
    {
        return [
            '[0-9\.]*', // numbers
            '[\*\/\+\-]?', // operators
        ];
    }

    protected function getNonCatchablePatterns()
    {
        return ['\s+', '(.)'];
    }

    protected function getType(&$value)
    {
        if (is_numeric($value)) {
            return self::T_NUMBER;
        }

        if ($value === '+') {
            return self::T_ADDITION;
        }

        if ($value === '-') {
            return self::T_SUBTRACTION;
        }

        if ($value === '/') {
            return self::T_DIVISION;
        }

        if ($value === '*') {
            return self::T_MULTIPLICATION;
        }

        return null;
    }
}
