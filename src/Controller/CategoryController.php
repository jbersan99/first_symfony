<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Category;


class CategoryController extends AbstractController
{
    /**
     * @Route("/category/{category_name}", name="create_category")
     */
    public function createProduct(ManagerRegistry $doctrine, string $category_name): Response
    {
        $category = new Category();
        $category->setName($category_name);

        $entityManager = $doctrine->getManager();
        $entityManager->persist($category);
        $entityManager->flush();

        return new Response(
            'Nueva categoria guardada con el nombre: '. $category->getName()
        );
    }
}
