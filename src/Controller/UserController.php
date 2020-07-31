<?php

namespace App\Controller;

use App\Entity\User;
use App\Event\UserEvent;
use App\Form\RegistrationType;
use App\Repository\UserRepository;
use App\Service\UserVerify;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserController extends AbstractController
{
    /**
     * @Route("/register", name="user_registration")
     */
    public function register(Request $request, UserPasswordEncoderInterface $encoder, EventDispatcherInterface $dispatcher)
    {
        $user = new User();

        $form = $this->createForm(RegistrationType::class, $user);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            
            $hash = $encoder->encodePassword($user, $user->getHash());
            
            $user->setHash($hash);

            $user->setActive(false);
            $user->setToken(bin2hex(random_bytes(60)));

            $manager = $this->getDoctrine()->getManager();
            $manager->persist($user);
            $manager->flush();

            $userEvent = new UserEvent($user);

            $dispatcher->dispatch($userEvent, UserEvent::NAME);
            
            $this->addFlash(
                'success',
                'Votre compte a bien été créé'
            );
        }

        return $this->render('user/registration.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/verify/{username}/token={token}", name="user_token_verify")
     */
    public function userVerify($token, $username, UserRepository $repo, UserVerify $userVerify)
    {
        $user = $repo->findOneByUsername($username);

        if ($userVerify->tokenVerify($username, $user, $token) ) {
            $this->addFlash(
                'success',
                'Votre compte a bien été validé'
            );
            return $this->redirectToRoute('home');
        } else {
            return $this->redirectToRoute('home');

        }
        
    }



}
