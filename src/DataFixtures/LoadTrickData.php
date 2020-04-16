<?php

namespace App\DataFixtures;

use DateTime;
use App\Entity\Group;
use App\Entity\Trick;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class LoadTrickData extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $tricks = [
            [
                "title" => "Backside Air",
                "description" => "Le grab star du snowboard qui peut être fait d'autant de façon différentes qu'il y a de styles de riders. Il consiste à attraper la carre arrière entre les pieds, ou légèrement devant, et à pousser avec sa jambe arrière pour ramener la planche devant. C'est une figure phare en pipe ou sur un hip en backside. C'est généralement avec ce trick que les riders vont le plus haut.",
                "modification_date" => "2020-03-12 10:00:00",
                "group" => "group-grab"
            ],
            [
                "title" => "Switch",
                "description" => "Lorsque l'on ride de son mauvais côté, tous les noms de figures sont précédées de la dénomination switch. Un regular fera donc ses tricks en switch, comme un goofie, et inversement.",
                "modification_date" => "2020-03-19 13:00:00",
                "group" => "group-flat"
            ],
            [
                "title" => "Frontside nose-roll",
                "description" => "Lorsque l'on ride en s'appuyant sur le nose de la planche, on décolle le reste de la planche pour faire un 180.",
                "modification_date" => "2020-04-19 13:00:00",
                "group" => "group-flat"
            ]
        ];
        
        foreach($tricks as $trick) {
            $trickObject = new Trick();
            $date = DateTime::createFromFormat('Y-m-d H:i:s', $trick["modification_date"]);
            $group = $this->getReference($trick['group']);
            $trickObject->setTitle($trick["title"])
            ->setDescription($trick["description"])
            ->setModificationDate($date)
            ->setGroupTrick($group);

            $manager->persist($trickObject);
        }

        $manager->flush();
    }
}
