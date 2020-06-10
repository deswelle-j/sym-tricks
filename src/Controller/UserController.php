<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserController extends AbstractController
{
    /**
     * @Route("/login", name="user_login")
     */
    public function login(AuthenticationUtils $utils)
    {
        $error = $utils->getLastAuthenticationError();
        $username = $utils->getLastUsername();

        return $this->render('user/login.html.twig', [
            'hasError' => $error !== null,
            'username' => $username
        ]);
    }

    /**
     * @Route("/logout", name="user_logout")
     */
    public function logout()
    {

    }

    /**
     * @Route("/register", name="user_registration")
     */
    public function register(Request $request, UserPasswordEncoderInterface $encoder)
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
            
            $this->addFlash(
                'success',
                'Votre compte a bien été créé'
            );
        }

        return $this->render('user/registration.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
