<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Services\TwigExtension;
use App\Entity\User;
use Faker\Factory;

class UserFixtures extends Fixture
{
    
    public function __construct()
    {
        $this->faker = Factory::create();
    }

    public function load(ObjectManager $em)
    {
        $twig = new TwigExtension();
        for ($i=1; $i<=10; $i++):
            $item = $twig->numberToStringList($i);
            $phone = '0'.mt_rand(1,9).' '.mt_rand(10,20).' '.mt_rand(10,20).' '.mt_rand(10,20).' '.mt_rand(10,20);
            $zipcode = '750'.mt_rand(10,20);
            $user = new User();
            $user->setUsername('user'.$item);
            $user->setPassword('pass'.$item);
            $user->setRoles(['ROLE_USER']);
            $user->setLastname(strtoupper($this->faker->lastname));
            $user->setFirstname(ucfirst($this->faker->firstname));
            $user->setEmail($this->faker->email);
            $user->setPhone($phone);
            $user->setAddress($this->faker->address);
            $user->setZipcode($zipcode);
            $user->setCity('PARIS');
            $em->persist($user);
        endfor;
        $em->flush();
    }
    
}
