<?php

namespace App\DataFixtures;

use App\Entity\User; 
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

 
class AppFixtures extends Fixture
{  
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);

        $existingUsers = $manager->getRepository(User::class)->findAll();
        foreach ($existingUsers as $existingUser) {
            $manager->remove($existingUser);
        }
        $manager->flush(); 
    }
}
