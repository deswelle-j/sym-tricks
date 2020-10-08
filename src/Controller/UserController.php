<?php

namespace App\Controller;

use App\Entity\User;
use App\Event\UserEvent;
use App\Form\AccountType;
use App\Service\UserVerify;
use App\Form\RegistrationType;
use App\Form\PasswordResetType;
use App\Service\UploaderHelper;
use App\Event\RegistrationEvent;
use App\Event\ResetPasswordEvent;
use App\Repository\UserRepository;
use App\Form\PasswordForgottenType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserController extends AbstractController
{
    /**
     * @Route("/register", name="user_registration")
     */
    public function register(Request $request, UploaderHelper $uploaderHelper, UserPasswordEncoderInterface $encoder, EventDispatcherInterface $dispatcher)
    {
        $user = new User();

        $form = $this->createForm(RegistrationType::class, $user);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            
            $file = $form['avatar']->getData();
            if ($file) {
                $newFilename = $uploaderHelper->uploadTrickImage($file);

                // $imageEntity = $image->getData();
                $user->setAvatarPath($newFilename);
            }

            $hash = $encoder->encodePassword($user, $user->getHash());
            
            $user->setHash($hash);

            $user->setActive(false);
            $user->setToken(bin2hex(random_bytes(60)));

            $manager = $this->getDoctrine()->getManager();
            $manager->persist($user);
            $manager->flush();

            $userEvent = new RegistrationEvent($user);

            $dispatcher->dispatch($userEvent, RegistrationEvent::NAME);
            
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
     * @Route("/password-forgotten", name="user_password_forgotten")
     */
    public function passwordForgotten(Request $request, EventDispatcherInterface $dispatcher, UserRepository $repo)
    {
        $form = $this->createForm(PasswordForgottenType::class);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {

            if($form->get('email')->getData()) {
                $email = $form->get('email')->getData();
                $user = $repo->findOneByEmail($email);
                $user->setToken(bin2hex(random_bytes(60)));

                $manager = $this->getDoctrine()->getManager();
                $manager->persist($user);
                $manager->flush();

                $userEvent = new ResetPasswordEvent($user);
    
                $dispatcher->dispatch($userEvent, ResetPasswordEvent::NAME);
                
                $this->addFlash(
                    'success',
                    'Votre mot de passe a bien été réinitialisé'
                );
            }
        }

        return $this->render('user/passwordForgotten.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/account/{username}", name="user_my_account")
     */
    public function myAccount($username, UserRepository $repo, Request $request, UploaderHelper $uploaderHelper, UserPasswordEncoderInterface $encoder)
    {
        $user = $repo->findOneByUsername($username);

        $form = $this->createForm(AccountType::class);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            
            $file = $form['avatar']->getData();
            if ($file) {
                $newFilename = $uploaderHelper->uploadTrickImage($file);
                $user->setAvatarPath($newFilename);
            }

            $hash = $encoder->encodePassword($user, $user->getHash());
            $user->setHash($hash);

            $manager = $this->getDoctrine()->getManager();
            $manager->persist($user);
            $manager->flush();
            
            $this->addFlash(
                'success',
                'Votre compte a bien été mis a jour'
            );
        }

        return $this->render('user/my_account.html.twig', [
            'form' => $form->createView(),
            'user' => $user
        ]);
    }

    /**
     * @Route("/reset/{username}/token={token}", name="user_reset_password")
     */
    public function resetPassword($token, $username, Request $request, UserPasswordEncoderInterface $encoder, UserRepository $repo, UserVerify $userVerify)
    {
        $user = $repo->findOneByUsername($username);

        if ($userVerify->tokenVerify($username, $user, $token)) {

            $form = $this->createForm(PasswordResetType::class);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $hash = $form->get('hash')->getData();
                $hash = $encoder->encodePassword($user, $hash);
            
                $user->setHash($hash);

                $user->setToken("");

                $manager = $this->getDoctrine()->getManager();
                $manager->persist($user);
                $manager->flush();
                
                $this->addFlash(
                    'success',
                    'Votre mot de passe a bien été réinitialisé'
                );
                return $this->redirectToRoute('home');
            }
            return $this->render('user/passwordReset.html.twig', [
                'form' => $form->createView()
            ]);
        } else {
            return $this->redirectToRoute('home');
        }
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
            $user->setActive(true);
            $user->setToken("");

            $manager = $this->getDoctrine()->getManager();
            $manager->persist($user);
            $manager->flush();

            return $this->redirectToRoute('home');
        } else {
            return $this->redirectToRoute('home');

        }
        
    }



}
