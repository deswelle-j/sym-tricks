<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\Group;

class LoadGroupData extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $flat = new Group;
        $flat->setName('Flat');
        $manager->persist($flat);

        $grab = new Group;
        $grab->setName('Grab');
        $manager->persist($grab);

        $manager->flush();

        $this->addReference('group-flat', $flat);
        $this->addReference('group-grab', $grab);
    }
}
