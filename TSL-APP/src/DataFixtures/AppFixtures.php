<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    protected $encoder;

    public function __construct(UserPasswordHasherInterface $encoder){

        $this->encoder=$encoder;
        
    }



    public function load(ObjectManager $manager)
    {


        

         $user = new User();

         $hash = $this->encoder->hashPassword($user,"password"); 
         $user->setEmail('delphine@gmail.com')
            ->setPassword($hash)
            ->setFullName('SUPER ADMIN')
            ->setRoles(['ROLE_ADMIN']);

         $manager->persist($user);

        $manager->flush();
    }
}
