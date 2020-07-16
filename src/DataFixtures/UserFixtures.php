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
        $this->faker = Factory::create('fr_FR');
    }

    public function load(ObjectManager $em)
    {
        $twig = new TwigExtension();
        for ($i=1; $i<=10; $i++):
            $item = $twig->numberToStringList($i);
            $user = new User();
            $user->setUsername('user'.$item);
            $user->setPassword('pass'.$item);
            $user->setRoles(['ROLE_USER']);
            $user->setLastname(strtoupper($this->faker->lastname));
            $user->setFirstname(ucfirst($this->faker->firstname));
            $user->setEmail($this->faker->email);
            $user->setPhone($this->faker->phoneNumber);
            $user->setAddress($this->faker->address);
            $user->setZipcode($this->faker->postcode);
            $user->setCity(strtoupper($this->faker->city));
            $em->persist($user);
        endfor;
        $em->flush();
    }
    
}
