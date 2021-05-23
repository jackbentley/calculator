<?php

namespace App\Controller;

use App\Form\CalculatorType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CalculatorController extends AbstractController
{
    #[Route('/', name: 'calculator')]
    public function index(): Response
    {
        $calculatorForm = $this->createForm(CalculatorType::class);

        return $this->render(
            'calculator.html.twig',
            [
                'calculatorForm' => $calculatorForm->createView(),
            ]
        );
    }
}
