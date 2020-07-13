<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\User;

class UserFixtures extends Fixture
{
    
    public function load(ObjectManager $manager)
    {
        for ($i=1; $i<=10; $i++):
            $user = new User();
            $user->setUsername();
            $user->setLastname();
            $user->setFirstname();
            $user->setEmail();
            $user->setPhone();
            $user->setAddress($address);
            $user->setZipcode($zipcode);
            $user->setCity($city);
            $em->persist($user);
        endfor;
        $manager->flush();
    }
}
