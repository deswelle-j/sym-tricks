<?php

namespace App\EventListener;

use App\Event\RegistrationEvent;
use Symfony\Component\Mime\Email;
use Symfony\Component\Mailer\MailerInterface;

class UserMailingListener
{
    private $mailer;

    public function __construct(MailerInterface $mailer)
    {
        $this->mailer = $mailer;
    }

    public function OnAfterUserIsCreated(RegistrationEvent $registrationEvent)
    {

        $user = $registrationEvent->getUser();
        $token = $user->getToken();
        $username = $user->getUsername();
        $email = (new Email())
            ->from('testmail@gmail.com')
            ->to($user->getEmail())
            ->priority(Email::PRIORITY_HIGH)
            ->subject('Inscription sur Snowtrick')
            ->text("pour finaliser votre inscription cliquez sur ce lien http://127.0.0.1:8000/verify/{$username}/token={$token}")
            ->html('<p>See Twig integration for better HTML integration!</p>');

        $this->mailer->send($email);
    }
}