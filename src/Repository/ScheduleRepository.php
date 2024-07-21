<?php

namespace App\Repository;

use App\Entity\Schedule;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Schedule>
 */
class ScheduleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Schedule::class);
    }

    public function getFormattedSchedules(): array
    {
        $qb = $this->createQueryBuilder('schedule')
        ->orderBy('schedule.id', 'ASC');

        $schedules = $qb->getQuery()->getResult();

        $formattedSchedules = array_map(function ($schedule) {
            return [
                'dayName' => $schedule->getDayName(),
                'opening' => $schedule->getOpening()->format('H:i'),
                'closing' => $schedule->getClosing()->format('H:i'),
            ];
        }, $schedules);

        return $formattedSchedules;
    }

}
