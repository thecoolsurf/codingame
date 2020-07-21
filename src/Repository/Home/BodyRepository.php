<?php

namespace App\Repository\Home;

use App\Entity\Body;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class BodyRepository extends ServiceEntityRepository
{
    
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Body::class);
    }

    /**
     * 
     * @param string $slug
     * @return object
     */
    public function findBodyBySlug($slug)
    {
        $result = $this->createQueryBuilder('b')
            ->select('
                b.h2 AS h2, b.paragraph AS paragraph, b.icon AS icon,
                p.h1, p.slug
            ')
            ->leftJoin('b.page', 'p')
            ->where('p.slug = :slug')
            ->setParameter('slug', $slug)
            ->orderBy('b.id', 'ASC')
            ->getQuery()
            ->getArrayResult();
        return $result;
    }

}
