<?php

namespace App\Repository\Practice;

use App\Entity\Response;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class ResponseRepository extends ServiceEntityRepository
{
    
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Response::class);
    }

    public function findByQuestion($id): ?Response
    {
        $result = $this->createQueryBuilder('r')
            ->where('r.question = :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->getResult()
        ;
        return $result;
    }

}
