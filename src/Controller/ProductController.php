<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\Product;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use App\Repository\ProductRepository;

class ProductController extends AbstractController
{
    /**
     * @Route("/product", name="create_product")
     */
    public function createProduct(ManagerRegistry $doctrine, ValidatorInterface $validator): Response
    {
        $entityManager = $doctrine->getManager();

        $product = new Product();
        $product->setName("Raton");
        $product->setPrice(100);
        $product->setDescription('Ergonomic and stylish!');

        $errors = $validator->validate($product);
        if (count($errors) > 0) {
            return new Response((string) $errors, 400);
        } else {
            // tell Doctrine you want to (eventually) save the Product (no queries yet)
            $entityManager->persist($product);

            // actually executes the queries
            $entityManager->flush();

            return new Response('Nuevo producto guardado con el id ' . $product->getId());
        }
    }

    /**
     * @Route("/product/{id}", name="product_show")
     */
    public function show(int $id, ProductRepository $productRepository): Response
    {
        $product = $productRepository->find($id);

        if (!$product) {
            throw $this->createNotFoundException(
                'No se encontro el producto con ' . $id
            );
        }

        return new Response('Revisa este producto: ' . $product->getName());

        // or render a template
        // in the template, print things with {{ product.name }}
        // return $this->render('product/show.html.twig', ['product' => $product]);
    }
}
