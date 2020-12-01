<?php

namespace App\Service;

class UserVerify
{
    public function tokenVerify($userId, $user, $token)
    {
        if ($user->getId() == $userId && $user->getToken() == $token) {
            return true;
        } else {
            return false;
        }
    }
}
