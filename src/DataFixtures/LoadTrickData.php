<?php

namespace App\DataFixtures;


use App\Entity\Trick;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class LoadTrickData extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $tricks = [
            [
                "title" => "Backside Air",
                "description" => "Le grab star du snowboard qui peut être fait d'autant de façon différentes qu'il y a de styles de riders. Il consiste à attraper la carre arrière entre les pieds, ou légèrement devant, et à pousser avec sa jambe arrière pour ramener la planche devant. C'est une figure phare en pipe ou sur un hip en backside. C'est généralement avec ce trick que les riders vont le plus haut.",
                "group" => "group-grab"
            ],
            [
                "title" => "Switch",
                "description" => "Lorsque l'on ride de son mauvais côté, tous les noms de figures sont précédées de la dénomination switch. Un regular fera donc ses tricks en switch, comme un goofie, et inversement.",
                "group" => "group-flat"
            ],
            [
                "title" => "Frontside nose-roll",
                "description" => "Lorsque l'on ride en s'appuyant sur le nose de la planche, on décolle le reste de la planche pour faire un 180.",
                "group" => "group-flat"
            ],
            [
                "title" => "50-50",
                "description" => "A slide in which a snowboarder rides straight along a rail or other obstacle.",
                "group" => "group-slide"
            ],
            [
                "title" => "Lipslide",
                "description" => "A slide performed where the rider's trailing foot passes over the rail on approach, with their snowboard traveling perpendicular along the rail or other obstacle.[1] When performing a frontside lipslide, the snowboarder is facing downhill. When performing a backside lipslide, a snowboarder is facing uphill.",
                "group" => "group-slide"
            ],
            [
                "title" => "Bluntslide",
                "description" => "A slide performed where the rider's leading foot passes over the rail on approach, with their snowboard traveling perpendicular and trailing foot directly above the rail or other obstacle (like a tailslide). When performing a frontside bluntslide, the snowboarder is facing uphill. When performing a backside bluntslide, the snowboarder is facing downhill.",
                "group" => "group-slide"
            ],
            [
                "title" => "Tailpress",
                "description" => "A trick performed by sliding along an obstacle, with pressure being put on the tail of the board, such that the nose of the board is raised in the air.",
                "group" => "group-slide"
            ],
            [
                "title" => "Gutterball",
                "description" => "The Gutterball is a one footed (front foot is strapped in and the rear foot is unstrapped ) front boardslide with a backhanded seatbelt nose grab, resembling the body position that someone would have after releasing a bowling ball down a bowling ally. This trick was invented and named by Jeremy Cameron which won him a first place in the Morrow Snowboards 'FAME WAR' Best Trick contest in 2009.",
                "group" => "group-slide"
            ],
            [
                "title" => "Back flip",
                "description" => "Flipping backwards (like a standing backflip) off of a jump.",
                "group" => "group-flip"
            ],
            [
                "title" => "Backside Misty",
                "description" => "After a rider learns the basic backside 540 off the toes, the Misty Flip can be an easy next progression step. Misty Flip is quite different than the backside rodeo, because instead of corking over the heel edge with a back flip motion, the Misty corks off the toe edge specifically and has more of a Front Flip in the beginning of the trick, followed by a side flip coming out to the landing.",
                "group" => "group-flip"
            ],
            [
                "title" => "Haakon flip",
                "description" => "An aerial maneuver performed in a halfpipe by taking off backwards, and performing an inverted 720° rotation. The rotation mimics a half-cab leading to McTwist, and is named after freestyle legend Terje Haakonsen of Norway.",
                "group" => "group-flip"
            ],
            [
                "title" => "McTwist",
                "description" => "A forward-flipping backside 540, performed in a halfpipe, quarterpipe, or similar obstacle. The rotation may continue beyond 540° (e.g., McTwist 720). The origin of this trick comes from vert ramp skateboarding, and was first performed on a skateboard by Mike McGill.",
                "group" => "group-flip"
            ],
            [
                "title" => "Double McTwist",
                "description" => "Shaun White is credited as the creator of the Double McTwist 1260, but Ben Stewart performs the trick in some of the earliest archival footage. Shaun White was the first athlete to perform the trick in competition at the 2010 Winter Olympics giving it worldwide recognition and giving it the name 'Tomahawk'. Since then, numerous athletes have performed the Double McTwist 1260 including Iouri Podladtchikov.",
                "group" => "group-flip"
            ],
            [
                "title" => "Frontside Rodeo",
                "description" => "The basic frontside rodeo is all together a 540. It essentially falls into a grey area between an off axis frontside 540 and a frontside 180 with a back flip blended into it. The grab choice and different line and pop factors can make it more flipy or more of an off-axis spin. Frontside rodeo can be done off the heels or toes and with a little more spin on the Z Axis can go to 720 or 900. It is possible to do it to a 1080 but, if there is too much flip in the spin, it can be hard not to over flip when going past 720 and 900. The bigger the Z Axis spin, the later the inverted part of the rotation should be. Gaining control on big spin rodeos, may lead to a double cork or a second flip rotation in the spin, if the rider has developed a comfort level with double flips on the tramp or other gymnastic environment.;Rodeo flip; frontside rodeo: A frontward-flipping frontside spin done off the toe-edge. Most commonly performed with a 540° rotation, but also performed as a 720°, 900°, etc..",
                "group" => "group-flip"
            ],
            [
                "title" => "Ninety Roll",
                "description" => "A trick performed by back-flipping toward the landing of a jump, with a total rotation of 180° backside (i.e. spin 90° backside-backflip-spin 90°), therefore landing fakie. Essentially, this is a backside 180 backflip. This trick is sometimes confused with a backside Rodeo, though the Ninety Roll has a much more linear axis of rotation.",
                "group" => "group-flip"
            ],
            [
                "title" => "Sato flip",
                "description" => "Halfpipe trick done by Rob Kingwill (Sato is the Japanese word for sugar). It is something like a frontside McTwist. The rider rides up the transition of the pipe as if doing a frontside 540°, pops in the air and grabs frontside, then throws head, shoulders, and hips down.",
                "group" => "group-flip"
            ],
            [
                "title" => "Bloody Dracula",
                "description" => "A trick in which the rider grabs the tail of the board with both hands. The rear hand grabs the board as it would do it during a regular tail-grab but the front hand blindly reaches for the board behind the riders back.",
                "group" => "group-grab"
            ],
            [
                "title" => "Canadian Bacon",
                "description" => "The rear hand reaches behind the rear leg to grab the toe edge between the bindings while the rear leg is boned.",
                "group" => "group-grab"
            ],
            [
                "title" => "Crail",
                "description" => "The rear hand grabs the toe edge in front of the front foot while the rear leg is boned. Alternatively, some consider any rear handed grab in front of the front foot on the toeside edge a crail grab, classifying a grab to the nose a 'nose crail' or 'real crail'.",
                "group" => "group-grab"
            ],
            [
                "title" => "Drunk Driver",
                "description" => "Similar to a Truck driver, it is a stalefish grab and mute grab performed at the same time.",
                "group" => "group-grab"
            ],
            [
                "title" => "Japan air",
                "description" => "The front hand grabs the toe edge in between the feet and the front knee is pulled to the board.",
                "group" => "group-grab"
            ],
            [
                "title" => "Lien air",
                "description" => "When performing a frontside air on transition, the snowboarder grabs heelside in front or behind the leading binding with their leading hand. In order for it to be a Lien air, the board can not be tweaked and has to be kept flat. The origin of the name of the trick is the reverse spelling of skateboarder Neil Blender's first name.",
                "group" => "group-grab"
            ],
        ];
        $index = 0;
        foreach($tricks as $trick) {
            $trickObject = new Trick();
            
            $group = $this->getReference($trick['group']);
            $trickObject->setTitle($trick["title"])
            ->setDescription($trick["description"])
            ->setGroupTrick($group);

            $manager->persist($trickObject);
            $manager->flush();
            $trickName = 'trick-'. $index;
            $this->setReference($trickName, $trickObject);
            
            $index++;
        }
    }

    public function getDependencies()
    {
        return array(
            LoadGroupData::class
        );
    }
}
