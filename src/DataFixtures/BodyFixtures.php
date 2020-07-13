<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\Body;

class AppFixtures extends Fixture
{
    
    public function load(ObjectManager $em)
    {
        for ($i = 0; $i < 20; $i++) {
            $entity = new Body();
            $entity->setTitle('product '.$i);
            $entity->setPrice(mt_rand(10, 100));
            $em->persist($entity);
        }
        $em->flush();
    }
    
}
