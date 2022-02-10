<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ApiUserController extends AbstractController
{
    /**
     * @Route("/api/user/{id}", name="api_user_item_get", methods={"GET"})
     */
    public function item(User $user): Response
    {
        return $this->json(
        $user, 200, [],
        ["groups" => "customers:read"]   
        ); 
    }
}
