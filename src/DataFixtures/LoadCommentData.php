<?php

namespace App\DataFixtures;

use App\Entity\Comment;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class LoadCommentData extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $comments = [
            [
                'content' => 'Lorem ipsum dolor sit amet.',
                'trick' => 'trick-1',
                'author' => 'user-flaty'
            ],
            [
                'content' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Quisquam sequi quidem distinctio! Laboriosam?.',
                'trick' => 'trick-1',
                'author' => 'user-flaty'
            ],
            [
                'content' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Harum, repellendus. Quibusdam hic sint illo aperiam?',
                'trick' => 'trick-3',
                'author' => 'user-flaty'
            ],
        ];

            foreach($comments as $comment) {
                $commentObject = new Comment();
                
                $commentObject->setContent($comment['content']);
                $commentObject->setTrick($this->getReference($comment['trick']));
                $commentObject->setAuthor($this->getReference($comment['author']));
                $manager->persist($commentObject);
            }


            $manager->flush();
    }

    public function getDependencies()
    {
        return array(
            LoadUserData::class,
            LoadTrickData::class
        );
    }
}
