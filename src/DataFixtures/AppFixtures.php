<?php

namespace App\DataFixtures;

use App\Entity\Trick;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $tricks = [
            [
                "title" => "Backside Air",
                "description" => "Le grab star du snowboard qui peut être fait d'autant de façon différentes qu'il y a de styles de riders. Il consiste à attraper la carre arrière entre les pieds, ou légèrement devant, et à pousser avec sa jambe arrière pour ramener la planche devant. C'est une figure phare en pipe ou sur un hip en backside. C'est généralement avec ce trick que les riders vont le plus haut.",
                "modification_date" => "2020-03-12 10:00:00"
            ],
            [
                "title" => "Switch",
                "description" => "Lorsque l'on ride de son mauvais côté, tous les noms de figures sont précédées de la dénomination switch. Un regular fera donc ses tricks en switch, comme un goofie, et inversement.",
                "modification_date" => "2020-03-19 13:00:00"
            ]
        ];

        foreach($tricks as $trick) {
            $trickObject = new Trick();
            $date = DateTime::createFromFormat('Y-m-d H:i:s', $trick["modification_date"]);
            $trickObject->setTitle($trick["title"])
            ->setDescription($trick["description"])
            ->setModificationDate($date);

            $manager->persist($trickObject);
        }

        $manager->flush();
    }
}
