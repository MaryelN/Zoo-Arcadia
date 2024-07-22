<?php

namespace App\DataFixtures;

use App\Entity\Contact;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class ContactFixtures extends Fixture
{
  
  public function load(ObjectManager $manager): void
  {   
      $faker = Factory::create('fr_FR');
      
      for ($i = 0; $i < 5; $i++) {

          $contact = new Contact();
          $contact->setFullName($faker->name);
          $contact->setEmail($faker->email);
          $contact->setSubject($faker->sentence);
          $contact->setMessage($faker->paragraph);
          $manager->persist($contact);

        }

        $manager->flush();
  }
}