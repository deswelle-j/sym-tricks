<?php

namespace App\EventListener;

use App\Event\UserEvent;
use Symfony\Component\Mime\Email;
use Symfony\Component\Mailer\MailerInterface;

class UserMailingListener
{
    private $mailer;

    public function __construct(MailerInterface $mailer)
    {
        $this->mailer = $mailer;
    }

    public function OnAfterUserIsCreated(UserEvent $userEvent)
    {

        $user = $userEvent->getUser();
        $token = $user->getToken();
        $username = $user->getUsername();
        $email = (new Email())
            ->from('nemirel1@gmail.com')
            ->to($user->getEmail())
            ->priority(Email::PRIORITY_HIGH)
            ->subject('Inscription sur Snowtrick')
            ->text("pour finaliser votre inscription cliquez sur ce lien http://127.0.0.1:8000/verify/{$username}/token={$token}")
            ->html('<p>See Twig integration for better HTML integration!</p>');

        $this->mailer->send($email);
    }
}