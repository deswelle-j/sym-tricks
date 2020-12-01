<?php

namespace App\Event;

use App\Entity\User;
use Symfony\Contracts\EventDispatcher\Event;

class RegistrationEvent extends Event
{
    public const NAME = 'user.register';
    protected $user;

    public function __construct(User $user) {
        $this->user = $user;
    }

    public function getUser()
    {
        return $this->user;
    }
}
