<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Category;

class CategoryFixtures extends Fixture
{
    
    public function load(ObjectManager $em)
    {
        $menus = ['php', 'javascript', 'mysql'];
        
        foreach ($menus as $slug):
            $entity = new Category();
            $entity->setTitle(ucfirst($slug));
            $entity->setSlug($slug);
            $em->persist($entity);
        endforeach;
        $em->flush();
    }
    
}
