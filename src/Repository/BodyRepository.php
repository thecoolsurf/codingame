<?php

namespace App\Repository;

use App\Entity\Body;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;

class BodyRepository extends ServiceEntityRepository
{
    
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Body::class);
    }

    // /**
    //  * @return Body[] Returns an array of Body objects
    //  */
    public function findBodyBySlug(Request $request)
    {
        $slug = $request->query->get('url');
        return $this->createQueryBuilder('b')
            ->andWhere('b.slug = :slug')
            ->setParameter('slug', $slug)
            ->orderBy('b.id', 'ASC')
            ->setMaxResults(1)
            ->getQuery()
            ->getResult()
        ;
    }

}
