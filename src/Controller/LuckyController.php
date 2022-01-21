<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LuckyController extends AbstractController
{
    /**
     * @Route("/lucky/number/{number}", name="lucky")
     */
    public function number(int $number): Response
    {
        $number_result = random_int($number, 100);

        return new Response(
            '<html><body>Lucky number: '.$number_result.'</body></html>'
        );
    }
}
