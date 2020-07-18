<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use App\Services\TwigExtension;
use App\Entity\User;
use Faker\Factory;

class UserFixtures extends Fixture
{
    
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->faker = Factory::create('fr_FR');
        $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $em)
    {
        $twig = new TwigExtension();
        for ($i=1; $i<=10; $i++):
            $item = $twig->numberToStringList($i);
            $user = new User();
            $pass = $this->passwordEncoder->encodePassword($user,'pass'.$twig->numberToStringList($i));
            $user->setUsername('user'.$item);
            $user->setPassword($pass);
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
