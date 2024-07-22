<?php

namespace App\Repository;

use App\Entity\Animal;
use App\Entity\Habitat;
use App\Entity\Race;
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


    public function findByRace(Race $race): array
    {
        return $this->createQueryBuilder('animal')
            ->andWhere('animal.race = :race')
            ->setParameter('race', $race)
            ->getQuery()
            ->getResult();
    }


    public function findAllWithImages(): array
    {
        return $this->createQueryBuilder('animal')
            ->leftJoin('animal.images', 'image')
            ->addSelect('image')
            ->getQuery()
            ->getResult();
    }


    public function findAnimalWithDetails(int $id): ?Animal
    {
        return $this->createQueryBuilder('animal')
            ->leftJoin('animal.images', 'image')
            ->addSelect('image')
            ->leftJoin('animal.animalReports', 'report')
            ->addSelect('report')
            ->leftJoin('animal.race', 'race')
            ->addSelect('race')
            ->leftJoin('animal.habitat', 'habitat')
            ->addSelect('habitat')
            ->where('animal.id = :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->getOneOrNullResult();
    }
}