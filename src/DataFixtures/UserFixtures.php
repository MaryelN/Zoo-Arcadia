<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    private UserPasswordHasherInterface $passwordHasher;
    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        for ($i = 0; $i < 5; $i++) {

            $user = new User();
            $user->setEmail($faker->email);
            $user->setRoles(['ROLE_USER']);
            $user->setPassword(
                $this->passwordHasher->hashPassword($user,'password')
            );
            $user->setLastname($faker->lastName);
            $user->setName($faker->firstName);
            $user->setTimestamp(new \DateTimeImmutable());

            $manager->persist($user);
            $this->addReference('user_' . $i, $user); 
        }
            //veterinary
            $user = new User();
            $user->setEmail('vboucher@hotmail.fr');
            $user->setRoles(['ROLE_VETERINARY']);
            $user->setPassword(
                $this->passwordHasher->hashPassword($user,'password')
            );
            $user->setLastname($faker->lastName);
            $user->setName($faker->firstName);
            $user->setTimestamp(new \DateTimeImmutable());

            $manager->persist($user);
            $this->addReference('user_veterinary', $user);
            
            //admin
            $user = new User();
            $user->setEmail('arcadia@zoo.com');
            $user->setRoles(['ROLE_ADMIN']);
            $user->setPassword(
                $this->passwordHasher->hashPassword($user,'admin.zoo2024')
            );
            $user->setLastname($faker->lastName);
            $user->setName($faker->firstName);
            $user->setTimestamp(new \DateTimeImmutable());

            $manager->persist($user);
            $this->addReference('user_admin', $user);


        $manager->flush();
    }
}
