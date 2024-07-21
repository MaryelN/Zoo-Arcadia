<?php

namespace App\Repository;

use App\Entity\Animal;
use App\Entity\Habitat;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Animal>
 */
class AnimalRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Animal::class);
    }

    public function findByHabitat(Habitat $habitat): array
    {
        return $this->createQueryBuilder('animal')
            ->andWhere('animal.habitat = :habitat')
            ->setParameter('habitat', $habitat)
            ->getQuery()
            ->getResult();
    }

    public function findAllWithImages(): array
    {
        return $this->createQueryBuilder('a')
            ->leftJoin('a.images', 'i')
            ->addSelect('i')
            ->getQuery()
            ->getResult();
    }

        /**
     * Find an animal by its ID with its related entities.
     *
     * @param int $id
     * @return Animal|null
     */
    public function findAnimalWithDetails(int $id): ?Animal
    {
        return $this->createQueryBuilder('a')
            ->leftJoin('a.images', 'i')
            ->addSelect('i')
            ->leftJoin('a.animalReports', 'r')
            ->addSelect('r')
            ->leftJoin('a.race', 'race')
            ->addSelect('race')
            ->leftJoin('a.habitat', 'habitat')
            ->addSelect('habitat')
            ->where('a.id = :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->getOneOrNullResult();
    }
}