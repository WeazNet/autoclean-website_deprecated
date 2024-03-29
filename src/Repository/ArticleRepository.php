<?php

namespace App\Repository;

use App\Entity\Article;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Doctrine\ORM\Query;

/**
 * @method Article|null find($id, $lockMode = null, $lockVersion = null)
 * @method Article|null findOneBy(array $criteria, array $orderBy = null)
 * @method Article[]    findAll()
 * @method Article[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ArticleRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Article::class);
    }

    public function findAllByInterval(): array
    {
        $now = new \DateTime();
        $interval = 60;
        $timestamp = $now->getTimestamp() - $interval;

        return $this->createQueryBuilder('a')
            ->Where("a.created_at <= $timestamp")
            ->getQuery()
            ->getResult();
    }

     /**
     * @return Query
     */
    public function findAllQuery(): Query 
    {
        return $this->createQueryBuilder('a')
                      ->orderBy('a.date', 'DESC')
                      ->getQuery();
    }

    public function findAllLatest()
    {
        return $this->createQueryBuilder('a')
                    ->orderBy('a.date', 'DESC')
                    ->setMaxResults(3)
                    ->getQuery()
                    ->getResult();
    }

    // /**
    //  * @return Article[] Returns an array of Article objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Article
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
