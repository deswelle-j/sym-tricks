<?php

namespace App\EventListener;

use App\Event\ResetPasswordEvent;
use Symfony\Component\Mime\Email;
use Symfony\Component\Mailer\MailerInterface;

class ResetPasswordListener
{
    private $mailer;
    private $send_email;

    public function __construct(MailerInterface $mailer, string $send_email)
    {
        $this->mailer = $mailer;
        $this->send_email = $send_email;
    }

    public function OnAfterUserRequestPassword(ResetPasswordEvent $resetPasswordEvent)
    {

        $user = $resetPasswordEvent->getUser();
        $token = $user->getToken();
        $username = $user->getUsername();
        $email = (new Email())
            ->from($this->send_email)
            ->to($user->getEmail())
            ->priority(Email::PRIORITY_HIGH)
            ->subject('Réinitialisation de mot de passe sur Snowtrick')
            ->text("pour finaliser votre inscription cliquez sur ce lien http://127.0.0.1:8000/reset/{$username}/token={$token}")
            ->html('<p>See Twig integration for better HTML integration!</p>');

        $this->mailer->send($email);
    }
}