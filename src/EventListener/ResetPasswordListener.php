<?php

namespace App\EventListener;

use App\Event\ResetPasswordEvent;
use Symfony\Component\Mime\Email;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class ResetPasswordListener
{
    private $mailer;
    private $send_email;
    private $router;

    public function __construct(MailerInterface $mailer, string $send_email, UrlGeneratorInterface $router)
    {
        $this->mailer = $mailer;
        $this->send_email = $send_email;
        $this->router = $router;
    }

    public function OnAfterUserRequestPassword(ResetPasswordEvent $resetPasswordEvent)
    {

        $user = $resetPasswordEvent->getUser();
        $token = $user->getToken();
        $userId = $user->getId();
        $url = $this->router->generate('user_reset_password', ['userId' => $userId, 'token' => $token], UrlGeneratorInterface::ABSOLUTE_URL);
        $email = (new TemplatedEmail())
            ->from($this->send_email)
            ->to($user->getEmail())
            ->priority(Email::PRIORITY_HIGH)
            ->subject('Réinitialisation de mot de passe sur Snowtrick')
            ->text("{$url}")
            ->context([
                'user' => $user,
                'token' => $token
            ])
            ->text("{$url}")
            ->htmlTemplate('email/passwordForgotten.html.twig');

        $this->mailer->send($email);
    }
}