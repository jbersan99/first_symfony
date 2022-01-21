<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class OperacionesController extends AbstractController
{
    /**
     * @Route("/operaciones/sumar/{numero1}/{numero2}", name="operacion_suma", requirements={"numero1"="\d+", "numero2"="\d+"})
     */
    public function suma(int $numero1, int $numero2): Response
    {
        $operacion = "suma";
        $number_result = $numero1+$numero2;;

        return $this->render('operaciones.html.twig', [
            'operacion' => $operacion,
            'numero1' => $numero1,
            'numero2' => $numero2,
            'resultado' => $number_result,
        ]);
    }

    /**
     * @Route("/operaciones/restar/{numero1}/{numero2}", name="operacion_resta" , requirements={"numero1"="\d+", "numero2"="\d+"})
     */
    public function resta(int $numero1, int $numero2): Response
    {
        $operacion = "resta";
        $number_result = $numero1-$numero2;;

        return $this->render('operaciones.html.twig', [
            'operacion' => $operacion,
            'numero1' => $numero1,
            'numero2' => $numero2,
            'resultado' => $number_result,
        ]);
    }

    /**
     * @Route("/operaciones/multiplicar/{numero1}/{numero2}", name="operacion_multiplica" , requirements={"numero1"="\d+", "numero2"="\d+"})
     */
    public function multiplica(int $numero1, int $numero2): Response
    {
        $operacion = "multiplicación";
        $number_result = $numero1*$numero2;;

        return $this->render('operaciones.html.twig', [
            'operacion' => $operacion,
            'numero1' => $numero1,
            'numero2' => $numero2,
            'resultado' => $number_result,
        ]);
    }

    /**
     * @Route("/operaciones/dividir/{numero1}/{numero2}", name="operacion_division" , requirements={"numero1"="\d+", "numero2"="\d+"})
     */
    public function dividir(int $numero1, int $numero2): Response
    {
        $operacion = "división";
        $number_result = $numero1/$numero2;;

        return $this->render('operaciones.html.twig', [
            'operacion' => $operacion,
            'numero1' => $numero1,
            'numero2' => $numero2,
            'resultado' => $number_result,
        ]);
    }
}
