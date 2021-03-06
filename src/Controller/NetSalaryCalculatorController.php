<?php

declare(strict_types=1);

namespace App\Controller;

use App\Form\NetSalary;
use App\Form\NetSalaryType;
use Phpcy\GrossNetSalaryCalculator\Calculator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class NetSalaryCalculatorController extends AbstractController
{
    /**
     * @Route("/", name="net_salary_calculator")
     * @param Calculator $calculator
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function __invoke(Calculator $calculator, Request $request): Response
    {
        $form = $this->createForm(NetSalaryType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() === false || $form->isValid() === false) {
            return $this->render('index.html.twig', [
                'form' => $form->createView(),
            ]);
        }

        /** @var NetSalary $data */
        $data = $form->getData();
        $result = $calculator->calculateNetSalary($data->grossSalary, $data->months);

        return $this->render('index.html.twig', [
            'form' => $form->createView(),
            'result' => $result,
        ]);
    }
}
