<?php

namespace App\Repository\Practice;

use App\Entity\Category;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use App\Repository\Practice\CategoryRepository as CategoryRep;
use App\Repository\Practice\QuestionRepository as QuestionRep;

class CategoryRepository extends ServiceEntityRepository
{
    
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Category::class);
    }
    
    public function getNavigationCategories(CategoryRep $category_rep, QuestionRep $question_rep)
    {
        $categories = $category_rep->findAll();
        foreach ($categories as $category):
            $id = $category->getId();
            $slug = $category->getSlug();
            $questions[$id] = $question_rep->findByCategory($slug);
        endforeach;
        return [$categories,$questions];
    }
    
}
