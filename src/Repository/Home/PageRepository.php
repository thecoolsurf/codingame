<?php

namespace App\Repository\Home;

use App\Entity\Page;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;

class PageRepository extends ServiceEntityRepository
{
    
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Page::class);
    }

    /**
     * 
     * @param Request $request
     * @return array objet
     */
    public function findPageBySlug(Request $request)
    {
        $slug = $request->attributes->get('_route');
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
