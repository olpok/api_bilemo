<?php

namespace App\Controller;

use App\Repository\ProductRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ApiProductController extends AbstractController
{
    #[Route('/api/product', name: 'api_product_collection',  methods: 'GET')]
    public function collection(ProductRepository $productRepository): Response
    {
        return $this->json(
        $productRepository->findAll(), 200, [],
        ["groups" => "products:read"]   
        );         
    }
}
