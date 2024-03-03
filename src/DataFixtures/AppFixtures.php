<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{

    public function __construct(private UserPasswordHasherInterface $userPasswordHasherInterface) {}

    public function load(ObjectManager $manager): void
    {
        $user = new User();
        $user->setEmail('admin@site.com');
        $user->setRoles(['ROLE_ADMIN']);
        $user->setFirstname('Admin');
        $user->setLastname('Admin');
        $user->setKeyfirst('Mjokjjjspupuzepopjhuoy656');
        $user->setPathticket('Mjokjjjspupuz/ajepopjhuoy656');
        $user->setPassword($this->userPasswordHasherInterface->hashPassword($user,'password'));
        $manager->persist($user);

        $user = new User();
        $user->setEmail('user1@site.com');
        $user->setRoles(['ROLE_USER']);
        $user->setFirstName('User');
        $user->setLastName('User');
        $user->setKeyfirst('Mjokjhuoy656');
        $user->setPathticket('Mjokjjjspupuz/ajepopjhuoy656');
        $user->setPassword($this->userPasswordHasherInterface->hashPassword($user,'password'));
        $manager->persist($user);


        $manager->flush();
    }
}
