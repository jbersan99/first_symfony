<?php

namespace App\Controller;

use App\Entity\Category;
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
     * @Route("/product/{category_name}", name="create_product")
     */
    public function createProduct(ManagerRegistry $doctrine, string $category_name): Response
    {
        $category = new Category();
        $category->setName($category_name);

        $product = new Product();
        $product->setName("Teclado");
        $product->setPrice(200);
        $product->setDescription('Ergonomic and stylish!');

        $product->setCategory($category);

        $entityManager = $doctrine->getManager();
        $entityManager->persist($category);
        $entityManager->persist($product);
        $entityManager->flush();

        return new Response(
            'Nuevo producto guardado con el nombre: ' . $product->getName()
                . ' y su categoria es : ' . $category->getName()
        );
    }

    /**
     * @Route("/product_show/{id}", name="product_show")
     */
    public function show(ManagerRegistry $doctrine, int $id): Response
    {
        $product = $doctrine->getRepository(Product::class)->find($id);

        $categoryName = $product->getCategory()->getName();

        return new Response('El producto con nombre ' . $product->getName() . ' y su categoria es ' . $categoryName);
    }


    /**
     * @Route("/products/{id}", name="products")
     */
    public function showProducts(ManagerRegistry $doctrine, int $id): Response
    {
        $category = $doctrine->getRepository(Category::class)->find($id);

        $products = $category->getProducts();

        return $this->render('product.html.twig', array(
            'products' => $products,
            'category' => $category->getName()
        ));
    }
}
