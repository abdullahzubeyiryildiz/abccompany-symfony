<?php
namespace App\DataFixtures;
 
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class DefaulUserLoader extends Fixture
{
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    { 
        $user = new User();
        $user->setEmail('musteri1@abccompany.com');
        $user->setRoles(['ROLE_USER']);
        $encodedPassword = $this->encoder->encodePassword($user, '123456');
        $user->setPassword($encodedPassword);
     
        $user2 = new User();
        $user2->setEmail('musteri2@abccompany.com');
        $user2->setRoles(['ROLE_USER']);
        $encodedPassword2 = $this->encoder->encodePassword($user2, '123456');
        $user2->setPassword($encodedPassword2);
 
        $user3 = new User();
        $user3->setEmail('musteri3@abccompany.com');
        $user3->setRoles(['ROLE_USER']);
        $encodedPassword3 = $this->encoder->encodePassword($user3, '123456');
        $user3->setPassword($encodedPassword3);
 
        $manager->persist($user);
        $manager->persist($user2);
        $manager->persist($user3);
        $manager->flush();
    }
}