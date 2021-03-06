<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
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

        $flip = new Group;
        $flip->setName('Flip');
        $manager->persist($flip);

        $slide= new Group;
        $slide->setName('Slide');
        $manager->persist($slide);

        $manager->flush();

        $this->addReference('group-flat', $flat);
        $this->addReference('group-grab', $grab);
        $this->addReference('group-flip', $flip);
        $this->addReference('group-slide', $slide);
    }

    public function getOrder()
    {
        return 1; // ordre d'appel
    }
}
