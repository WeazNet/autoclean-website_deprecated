<?php

namespace App\Repository;

use App\Entity\Ad;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Doctrine\ORM\Query;
use App\Entity\AdSearch;

/**
 * @method Ad|null find($id, $lockMode = null, $lockVersion = null)
 * @method Ad|null findOneBy(array $criteria, array $orderBy = null)
 * @method Ad[]    findAll()
 * @method Ad[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AdRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Ad::class);
    }

    /**
     * @return Ad[]
     */
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
     * @return Ad[]
     */
    public function findAllLatest(): array
    {
        return $this->createQueryBuilder('a')
        ->setMaxResults(4)
        ->getQuery()
        ->getResult();
    }

    /**
     * @return Query
     */
    public function findAllQuery(AdSearch $search): Query {
        $query = $this->createQueryBuilder('a');
        if($search->getGlobal()) {
            $query->andWhere('a.name LIKE :global OR a.brand LIKE :global OR a.model LIKE :global')
                  ->setParameter('global', '%'.$search->getGlobal().'%');
        }
        if($search->getBrand()) {
            $query->andWhere('a.brand = :brand')
                  ->setParameter('brand', $search->getBrand());
        }
        if($search->getFuel()) {
            $query->andWhere('a.fuel = :fuel')
                  ->setParameter('fuel', $search->getFuel());
        }
        if($search->getGearbox()) {
            $query->andWhere('a.gearbox = :gearbox')
                  ->setParameter('gearbox', $search->getGearbox());
        }
        if($search->getSort()) {
            if($search->getSort() === 'year') {
                $query->orderBy("a.{$search->getSort()}", 'DESC');
            } else {
                $query->orderBy("a.{$search->getSort()}", 'ASC');
            }
        } else {
            $query->orderBy('a.date', 'DESC');
        }
        return $query->getQuery();
    }

    // /**
    //  * @return Ad[] Returns an array of Ad objects
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
    public function findOneBySomeField($value): ?Ad
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
