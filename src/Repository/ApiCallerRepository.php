<?php

namespace Tourze\JsonRPCCallerBundle\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Tourze\JsonRPCCallerBundle\Entity\ApiCaller;

/**
 * @method ApiCaller|null find($id, $lockMode = null, $lockVersion = null)
 * @method ApiCaller|null findOneBy(array $criteria, array $orderBy = null)
 * @method ApiCaller[]    findAll()
 * @method ApiCaller[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ApiCallerRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ApiCaller::class);
    }
}
