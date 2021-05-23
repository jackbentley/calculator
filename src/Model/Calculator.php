<?php

namespace App\Model;

use Symfony\Component\Validator\Constraints as Assert;

class Calculator
{
    #[Assert\NotBlank]
    private string $calculation;

    public function getCalculation(): string
    {
        return $this->calculation;
    }

    public function setCalculation(string $calculation): void
    {
        $this->calculation = $calculation;
    }
}
