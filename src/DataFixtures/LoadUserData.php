<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class LoadUserData extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $user = new User;
        $user->setUsername('flaty')
             ->setEmail('flaty@example.com')
             ->setHash('$2y$13$MbAljDu6zvR73tInFYZ2m.kBJHEmskyPTk/L0ZKKsN5LM9ThSCFlS')
             ->setActive(true)
             ->setAvatarPath('thumb-212196.jpg');

        $manager->persist($user);

        $this->addReference('user-flaty', $user);

        $manager->flush();
    }

    public function getOrder()
    {
        return 3; // ordre d'appel
    }
}
