<?php

namespace App\Controller;

use App\Entity\Product;
use App\Repository\ProductRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Cache;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Cache(expires="+1 month", public=true)
 */
//#[Cache(lastModified: 'product.getUpdatedAt()', etag: "'Product' ~ product.getId() ~ product.getUpdatedAt().getTimestamp()")]
class ApiProductController extends AbstractController
{
    /**
     * @Route("/api/products", name="api_products_collection", methods={"GET"})
     */
    public function collection(ProductRepository $productRepository): Response
    {
        return $this->json(
        $productRepository->findAll(), 200, [],
        ["groups" => "products:list"]   
        );         
    }

    /**
     * @Route("/api/products/{id}", name="api_products_item_get",  methods={"GET"})
     * @param Product $product
     * @return Response
     */
    public function item(Product $product): Response
    {
        return $this->json(
        $product, 200, [],
        ["groups" => "product:read"]   
        );
    }
}
