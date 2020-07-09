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

    public function getRandomNumeric()
    {
        $datas = [];
        for ($i=0; $i<=50; $i++):
            for ($j=0; $j<=50; $j++):
                array_push($datas, mt_rand(-50,50));
            endfor;
        endfor;
        return $datas;
    }
    
    public function getPosition($lgx, $ltx, $lgy, $lty)
    {
        return sqrt(pow(($lgx-$ltx),2)+pow(($lgy-$lty),2));
    }
    
    /**
     * @return Question[] Returns an array of Question objects
     */
    public function findByCategory($slug)
    {
        $result = $this->createQueryBuilder('q')
            ->addSelect('q.id AS question_id')
            ->leftJoin('q.categories', 'c')
            ->where('c.slug = :slug')
            ->setParameter('slug', $slug)
            ->orderBy('q.id', 'ASC')
            ->getQuery()
            ->getResult();
        return $result;
    }

}
