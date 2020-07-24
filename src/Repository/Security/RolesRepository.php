<?php

namespace App\Repository\Security;

use App\Entity\Roles;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class RolesRepository extends ServiceEntityRepository
{
    
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Roles::class);
    }

    // /**
    //  * @return Roles[] Returns an array of Roles objects
    //  */
    public function findAllInArray()
    {
        $result = $this->createQueryBuilder('r')
            ->orderBy('r.id', 'ASC')
            ->getQuery()
            ->getArrayResult()
        ;
        var_dump($result);
        return $result;
    }

}
