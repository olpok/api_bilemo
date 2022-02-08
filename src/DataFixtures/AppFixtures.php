<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Entity\Brand;
use App\Entity\Product;
use App\Entity\Customer;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    /**
     * @var UserPasswordHasherInterface
     */
    private $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    public function load(ObjectManager $manager): void
    {
        $brand1 = new Brand();
        $brand1->setName('Apple');

        $brand2 = new Brand();
        $brand2->setName('Samsung');

        $brand3 = new Brand();
        $brand3->setName('Google');

        $manager->persist($brand1);
        $manager->persist($brand2);
        $manager->persist($brand3);

      
        // 5 users
        for ($i=1; $i <=5; $i++) {    
            $user = new User();
            $password = $this->passwordHasher->hashPassword($user, 'password');
            $user->setPassword($password);
            $user->setName("nom$i") 
                    ->setEmail(sprintf("%d@email.com", $i))
                    ->setRoles([]);

            $manager->persist($user); 
            
            //between 1 and 3 products)
               for ($j=1; $j <= mt_rand(1,3); $j++) { 
                        $product = new Product();
                        $product->setDescription( sprintf("description+%d", $j))
                                ->setModel(sprintf("model%d", $j))  
                                ->setBrand(${'brand'.rand(1,3)} ) 
                                ->setClient($user)       
                        ;
                        $manager->persist($product);
                }             

            //between 1 and 10 customers
                for ($k=1; $k <= mt_rand(1,10); $k++) { 
                        $customer = new Customer();
                        $customer->setFirstname("Prénom$k") 
                                ->setLastname("Nom$k") 
                                ->setEmail(sprintf("%d@email.com", $k))
                                ->setPhone("0". rand(125698754,985478547)) 
                                ->setClient($user) 
                        ;
                        $manager->persist($customer);
                }             
        }

        $manager->flush();
    }
}
