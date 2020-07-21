<?php

namespace App\Repository\Practice;

use App\Entity\Category;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use App\Repository\Practice\QuestionRepository as QuestionRep;

class CategoryRepository extends ServiceEntityRepository
{
    
    private $question_rep;
    
    public function __construct(ManagerRegistry $registry, QuestionRep $question_rep)
    {
        parent::__construct($registry, Category::class);
        $this->question_rep = $question_rep;
    }
    
    public function getNavigationCategories()
    {
        $categories = $this->findAll();
        foreach ($categories as $category):
            $id = $category->getId();
            $slug = $category->getSlug();
            $questions[$id] = $this->question_rep->findByCategory($slug);
        endforeach;
        return [$categories,$questions];
    }
    
}
