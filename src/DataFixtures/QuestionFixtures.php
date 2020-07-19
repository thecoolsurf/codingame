<?php
/* src/DataFixtures/QuestionFixtures.php */

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
            $category = new Category();
            $category->setTitle(ucfirst($slug));
            $category->setSlug($slug);
            $em->persist($category);
            for ($i=1; $i<=5; $i++):
                $question = new Question();
                $question->setCategories($category);
                $question->setTitle(ucfirst('Exercice '.$slug.' N°'.$i));
                $question->setDescription('Description de l\'exercice '.$slug.' N°'.$i);
                $em->persist($question);
            endfor;
        endforeach;
        $em->flush();
    }
    
}
