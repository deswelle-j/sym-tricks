<?php

namespace App\EventListener;

use App\Event\RegistrationEvent;
use Symfony\Component\Mime\Email;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class UserMailingListener
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

    public function OnAfterUserIsCreated(RegistrationEvent $registrationEvent)
    {

        $user = $registrationEvent->getUser();
        $token = $user->getToken();
        $userId = $user->getId();
        $url = $this->router->generate('user_token_verify', ['userId' => $userId, 'token' => $token], UrlGeneratorInterface::ABSOLUTE_URL);
        $email = (new Email())
            ->from($this->send_email)
            ->to($user->getEmail())
            ->priority(Email::PRIORITY_HIGH)
            ->subject('Inscription sur Snowtrick')
            ->text("{$url}")
            ->html('<p>See Twig integration for better HTML integration!</p>');

        $this->mailer->send($email);
    }
}