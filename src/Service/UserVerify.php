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
            return true;
        } else {
            return false;
        }
    }    
}