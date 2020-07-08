<?php

namespace App\Repository\Home;

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

    /**
     * 
     * @param Request $request
     * @return array objet
     */
    public function findBodyBySlug(Request $request)
    {
        $slug = $request->attributes->get('_route');
        return $this->createQueryBuilder('b')
            ->andWhere('b.slug = :slug')
            ->setParameter('slug', $slug)
            ->orderBy('b.id', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }

}
