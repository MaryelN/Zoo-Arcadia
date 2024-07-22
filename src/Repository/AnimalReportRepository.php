<?php

namespace App\Repository;

use App\Entity\Animal;
use App\Entity\AnimalReport;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<AnimalReport>
 */
class AnimalReportRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AnimalReport::class);
    }

    public function findLatestAnimalReport(Animal $animal): ?AnimalReport
    {
        return $this->createQueryBuilder('r')
            ->where('r.animal_id = :animal')
            ->setParameter('animal', $animal)
            ->orderBy('r.timestamp', 'DESC')
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult();
    }
}
