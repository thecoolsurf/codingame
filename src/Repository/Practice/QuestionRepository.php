<?php

namespace App\Repository\Practice;

use App\Entity\Question;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class QuestionRepository extends ServiceEntityRepository
{
    
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Question::class);
    }

    /**
     * @return Question[] Returns an array of Question objects
     */
    public function findQuetionForNavigation()
    {
        $query = $this->createQueryBuilder('q')
        ->addSelect('c.id, c.title, c.slug')
        ->leftJoin('q.categories', 'c')
//        ->where('c.slug LIKE :slug')
//        ->setParameter('slug', '%php%')
        ->orderBy('c.slug', 'ASC')
        ->getQuery()->getResult();
        return $query;
    }

    /**
     * @return Question[] Returns an array of Question objects
     */
    public function findQuetionByCategory($slug)
    {
        $query = $this->createQueryBuilder('q')
            ->leftJoin('Category.id', 'c')
            ->andWhere('c.slug = :slug')
            ->setParameter('slug', $slug)
            ->orderBy('q.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult();
        return $query;
    }

}
