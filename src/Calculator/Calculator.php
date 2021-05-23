<?php

namespace App\Calculator;

class Calculator
{
    private Lexer $lexer;

    public function __construct(Lexer $lexer)
    {
        $this->lexer = $lexer;
    }

    public function calculate(string $calculation): string
    {
        $this->lexer->setInput($calculation);
        $this->lexer->moveNext();

        if (!$this->lexer->isNextToken(Lexer::T_NUMBER)) {
            throw new InvalidCalculationException();
        }

        $this->lexer->moveNext();

        $value = (float) $this->lexer->token['value'];

        if ($this->isTooLarge($value)) {
            throw new InvalidCalculationException();
        }

        while (true) {
            if (!$this->lexer->lookahead) {
                break;
            }

            if ($this->lexer->isNextToken(Lexer::T_NUMBER) && ((float) $this->lexer->lookahead['value']) < 0) {
                $operator = Lexer::T_ADDITION;
            } else {
                if (!$this->lexer->isNextTokenAny([Lexer::T_ADDITION, Lexer::T_SUBTRACTION, Lexer::T_DIVISION, Lexer::T_MULTIPLICATION])) {
                    throw new InvalidCalculationException();
                }

                $this->lexer->moveNext();

                $operator = $this->lexer->token['type'];

                if (!$this->lexer->isNextToken(Lexer::T_NUMBER)) {
                    throw new InvalidCalculationException();
                }
            }

            $effector = (float) $this->lexer->lookahead['value'];

            if ($this->isTooLarge($effector)) {
                throw new InvalidCalculationException();
            }

            switch ($operator) {
                case Lexer::T_ADDITION:
                    $value = $this->add($value, $effector);
                    break;

                case Lexer::T_SUBTRACTION:
                    $value = $this->subtract($value, $effector);
                    break;

                case Lexer::T_DIVISION:
                    $value = $this->divide($value, $effector);
                    break;

                case Lexer::T_MULTIPLICATION:
                    $value = $this->multiply($value, $effector);
                    break;
            }

            $this->lexer->moveNext();
        }

        return $value;
    }

    private function isTooLarge(float $value): bool
    {
        return $value >= PHP_FLOAT_MAX;
    }

    private function add(float $a, float $b): float
    {
        return $a + $b;
    }

    private function subtract(float $a, float $b): float
    {
        return $a - $b;
    }

    private function divide(float $a, float $b): float
    {
        if ($a === (float) 0 || $b === (float) 0) {
            throw new InvalidCalculationException();
        }

        return $a / $b;
    }

    private function multiply(float $a, float $b): float
    {
        return $a * $b;
    }
}
