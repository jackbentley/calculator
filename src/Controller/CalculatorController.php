<?php

namespace App\Controller;

use App\Calculator\Calculator;
use App\Form\CalculatorType;
use App\Model\Calculator as CalculatorModel;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CalculatorController extends AbstractController
{
    private Calculator $calculator;

    /**
     * @param Calculator $calculator
     */
    public function __construct(Calculator $calculator)
    {
        $this->calculator = $calculator;
    }

    #[Route('/', name: 'calculator')]
    public function index(Request $request): Response
    {
        $calculatorModel = new CalculatorModel();
        $calculatorForm = $this->createForm(CalculatorType::class, $calculatorModel);

        $calculatorForm->handleRequest($request);

        if ($calculatorForm->isSubmitted() && $calculatorForm->isValid()) {
            try {
                $result = $this->calculator->calculate($calculatorModel->getCalculation());
            } catch (\Exception $e) {
                $result = 'Invalid';
            }
        }

        return $this->render(
            'calculator.html.twig',
            [
                'calculatorForm' => $calculatorForm->createView(),
                'result' => $result ?? '',
            ]
        );
    }
}
