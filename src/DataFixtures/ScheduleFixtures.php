<?php

namespace App\DataFixtures;

use App\Entity\Schedule;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ScheduleFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $schedule = new Schedule();
        $schedule->setDayName('Mardi');
        $schedule->setOpening(\DateTime::createFromFormat('H:i', '09:00'));
        $schedule->setClosing(\DateTime::createFromFormat('H:i', '19:00'));
        $manager->persist($schedule);

        $schedule = new Schedule();
        $schedule->setDayName('Mercredi');
        $schedule->setOpening(\DateTime::createFromFormat('H:i', '09:00'));
        $schedule->setClosing(\DateTime::createFromFormat('H:i', '19:00'));
        $manager->persist($schedule);

        $schedule = new Schedule();
        $schedule->setDayName('Jeudi');
        $schedule->setOpening(\DateTime::createFromFormat('H:i', '09:00'));
        $schedule->setClosing(\DateTime::createFromFormat('H:i', '19:00'));
        $manager->persist($schedule);
        
        $schedule = new Schedule();
        $schedule->setDayName('Vendredi');
        $schedule->setOpening(\DateTime::createFromFormat('H:i', '09:00'));
        $schedule->setClosing(\DateTime::createFromFormat('H:i', '19:00'));
        $manager->persist($schedule);
        
        $schedule = new Schedule();
        $schedule->setDayName('Samedi');
        $schedule->setOpening(\DateTime::createFromFormat('H:i', '09:00'));
        $schedule->setClosing(\DateTime::createFromFormat('H:i', '19:00'));
        $manager->persist($schedule);

        $schedule = new Schedule();
        $schedule->setDayName('Dimanche');
        $schedule->setOpening(\DateTime::createFromFormat('H:i', '09:00'));
        $schedule->setClosing(\DateTime::createFromFormat('H:i', '19:00'));
        $manager->persist($schedule);


        $manager->flush();
    }
}
