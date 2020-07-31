<?php

namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;

class UserVerify
{
    private $manager;

    public function __construct(EntityManagerInterface $entityManager){
        $this->manager = $entityManager;
    }

    public function tokenVerify($username, $user, $token)
    {
        if($user->getUsername() == $username && $user->getToken() == $token) {
            $user->setActive(true);
            $user->setToken("");

            
            $this->manager->persist($user);
            $this->manager->flush();

            return true;
        } else {
            return false;
        }
    }    
}