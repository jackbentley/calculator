<?php

namespace App\Tests\Calculator;

use App\Calculator\Calculator;
use App\Calculator\InvalidCalculationException;
use App\Calculator\Lexer;
use PHPUnit\Framework\TestCase;

class CalculatorTest extends TestCase
{
    private Lexer $lexer;
    private Calculator $calculator;

    protected function setUp(): void
    {
        $this->lexer = new Lexer();
        $this->calculator = new Calculator($this->lexer);
    }

    /**
     * @dataProvider gatherCalculations
     */
    public function testCalculate(string $calculation, bool $pass, float $result = null)
    {
        if (!$pass) {
            $this->expectException(InvalidCalculationException::class);
        }

        $value = $this->calculator->calculate($calculation);

        if ($pass) {
            self::assertEquals($result, $value);
        }
    }

    public function gatherCalculations()
    {
        return [
            ['1+1', true, 2],
            ['8-2', true, 6],
            ['10/4', true, 2.5],
            ['10*2.5', true, 25],
            ['11/0', false],
            ['0/11', true, 0],
            ['11//11', false],
            ['99+2*-/10', false],
            ['2.5+7-10', true, -0.5],
            ['-10+2', true, -8],
            ['--10+2', false],
            ['-10-10', true, -20],
        ];
    }
}
