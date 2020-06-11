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
        $email = (new Email())
            ->from('nemirel1@gmail.com')
            ->to($user->getEmail())
            //->cc('cc@example.com')
            //->bcc('bcc@example.com')
            //->replyTo('fabien@example.com')
            //->priority(Email::PRIORITY_HIGH)
            ->subject('Time for Symfony Mailer!')
            ->text('Sending emails is fun again!')
            ->html('<p>See Twig integration for better HTML integration!</p>');

        $this->mailer->send($email);
    }
}