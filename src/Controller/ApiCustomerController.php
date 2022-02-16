<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Customer;
use App\Repository\CustomerRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Serializer\Exception\NotEncodableValueException;

class ApiCustomerController extends AbstractController
{
    /**
     * @Route("/api/user/{id}", name="api_user_customers_collection_get", methods={"GET"})
     */
    public function collection(User $user): Response
    {
        return $this->json(
        $user, 200, [],
        ["groups" => "customers:read"]   
        ); 
    }

    /**
     * @Route("/api/customers", name="api_allcustomers_collection", methods={"GET"})
     */
    public function allCollection(CustomerRepository $customerRepository): Response
    {
        return $this->json(
        $customerRepository->findAll(), 200, [],
        ["groups" => "customer:show"]   
        ); 
    }

    /**
     * @Route("api/customers/{id}", name="api_customers_item_get", methods={"GET"})
     */
    public function item(Customer $customer): Response
    {
        return $this->json(
        $customer, 200, [],
        ["groups" => "customer:show"]   
        );
    }

    /**
     * @Route("/api/customers", name="api_customers_item_post",  methods={"POST"})
     */   
    public function post(Request $request, SerializerInterface $serializer, EntityManagerInterface $em, ValidatorInterface $validator){

        try{
            $customer= $serializer->deserialize($request->getContent(), Customer::class, 'json');

            $errors = $validator->validate($customer);

            if (count($errors) > 0) {
            return $this->json($errors, 400);
            }

            $em->persist($customer);
            $em->flush();

            return $this->json($customer, 201, [], ["groups" => "customer:show"]);
        } catch (NotEncodableValueException $e){
            return $this->json([
                'status' => 400,
                'message' => $e->getmessage()
            ], 400);
        } 

    }

    /**
     * @Route("api/customers/{id}", name="api_customers_item_delete", methods={"DELETE"})
     */
    public function delete(Customer $customer, EntityManagerInterface $entityManager) {
        $entityManager->remove($customer);
        $entityManager->flush();

        return $this->json(null, 204);
    }

}
