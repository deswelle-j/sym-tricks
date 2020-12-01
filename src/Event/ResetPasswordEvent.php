<?php

namespace App\Event;

use App\Entity\User;
use Symfony\Contracts\EventDispatcher\Event;

class ResetPasswordEvent extends Event
{
    public const NAME = 'user.reset-password';
    protected $user;

    public function __construct(User $user) {
        $this->user = $user;
    }

    public function getUser()
    {
        return $this->user;
    }
}