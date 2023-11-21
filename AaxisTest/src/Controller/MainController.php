<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Product;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/product', name: 'product.')]
class MainController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(): JsonResponse
    {
        return new Response(content:'<h1>/product endpoints list.</h1>');
    }
    
    
#[Route('/load', name: 'load', methods: ['POST'])]
public function load(Request $request, ProductRepository $productRepository): JsonResponse
{
    $data = json_decode($request->getContent(), true);

    // extract all sku values from an associative array that contains skus.
    $skus = array_column($data, 'sku') ?? [];
    $loadedProducts = [];
    $errorMessages = [];

    foreach ($skus as $sku) {
        $product = $productRepository->findOneBy(['sku' => $sku]);

        if ($product) {
            $loadedProducts[] = $product;
        } else {
            $errorMessages[] = 'Product with SKU ' . $sku . ' not found';
        }
    }

    $response = [
        'products' => $loadedProducts,
        'errors' => $errorMessages,
        'message' => 'Products loaded based on an array(list) of SKUs'
    ];

    return new JsonResponse($response);
}
    
    #[Route('/all', name: 'all', methods: ['GET'])]
    public function all(ProductRepository $productRepository): JsonResponse
    {
        $products = $productRepository->findAllProducts();
        return new JsonResponse([
            'all_products' => $products
        ]);
    }
    
    #[Route('/update', name: 'update', methods: ['PUT'])]
    public function update(Request $request, ProductRepository $productRepository, EntityManagerInterface $entityManager): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $updatedSKUs = [];
        $errorSKUs = [];

        foreach ($data as $productData) {
            $sku = $productData['sku'];
            $product = $productRepository->findOneBy(['sku' => $sku]);

            if ($product) {
                // Update fields of the existing product
                $product->setName($productData['name']);
                $product->setDescription($productData['description']);
                 // Update timestamps
                $product->setUpdatedAt(new \DateTime());
                // Update other fields as needed

                try {
                    $entityManager->persist($product);
                    $entityManager->flush();

                    $updatedSKUs[] = $sku;
                } catch (\Exception $e) {
                    $errorSKUs[] = $sku; // Record SKU with update error
                }
            } else {
                $errorSKUs[] = $sku; // Record SKU not found for update
            }
        }

        return new JsonResponse([
            'successfully_updated_product_skus' => $updatedSKUs,
            'skus_with_error' => $errorSKUs
        ]);
    }
}
