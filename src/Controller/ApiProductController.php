<?php

namespace App\Controller;

use App\Repository\ProductRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ApiProductController extends AbstractController
{
    #[Route('/api/product', name: 'api_product_index',  methods: 'GET')]
    public function index(ProductRepository $productRepository): Response
    {
       $products=$productRepository->findAll();

     return $this->json($products);
       
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/ApiProductController.php',
        ]);
    }
}
