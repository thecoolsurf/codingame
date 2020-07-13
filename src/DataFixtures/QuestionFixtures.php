<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Question;
use App\Entity\Category;

class QuestionFixtures extends Fixture
{
    
    public function load(ObjectManager $em)
    {
        $menus = ['php', 'javascript', 'mysql'];
        
        foreach ($menus as $slug):
            for ($i=1; $i<=5; $i++):
                $entity = new Question();
                $entity->setCategories(new Category());
                $entity->setResponse(null);
                $entity->setTitle(ucfirst('Exercice '.$slug.' N°'.$i));
                $entity->setDescription('Description de l\'exercice '.$slug.' N°'.$i);
                $em->persist($entity);
            endfor;
        endforeach;
        $em->flush();
    }
    
}
