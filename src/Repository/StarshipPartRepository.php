<?php

namespace App\Repository;

use App\Entity\StarshipPart;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Common\Collections\Criteria;
use Doctrine\Common\Collections\Collection;

/**
 * @extends ServiceEntityRepository<StarshipPart>
 */
class StarshipPartRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, StarshipPart::class);
    }
    // Moving the Criteria object to the repository allows us to reuse it in multiple places, and also to test it separately from the entity
    public static function createExtensiveCriteria(): Criteria
    {
        return Criteria::create()
            ->where(Criteria::expr()->gt('price', 1000));
    }
    /**
     * @return Collection<StarshipPart>
     */
    // combine criteria with a query builder to get the extensive parts of a starship, which will be executed in the database and not in memory, and also allows us to set a limit on the number of results
    public function getExtensiveParts(int $limit = 10): Collection
    {
        return $this->createQueryBuilder('sp') // Build a query for sp. sp table/entity inside the query
            ->addCriteria(self::createExtensiveCriteria()) // reusable filter/sort logic from another method:
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult();
    }

    //    /**
    //     * @return StarshipPart[] Returns an array of StarshipPart objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('s')
    //            ->andWhere('s.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('s.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?StarshipPart
    //    {
    //        return $this->createQueryBuilder('s')
    //            ->andWhere('s.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
