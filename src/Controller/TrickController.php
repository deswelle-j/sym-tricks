<?php

namespace App\Controller;

use App\Entity\Trick;
use App\Form\TrickType;
use Doctrine\ORM\EntityManager;
use App\Repository\TrickRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class TrickController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function home()
    {
        return $this->render('trick/home.html.twig', [
            'controller_name' => 'TrickController',
        ]);
    }

    /**
     * @Route("/trick/new", name="trick_new")
     * 
     * @return Response
     */

    public function new(Request $request)
    {
        $trick = new Trick();


        $form = $this->createForm(TrickType::class, $trick);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($trick);

            $manager->flush();
        }

        return $this->render('trick/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/trick/{slug}", name="trick_show")
     * 
     * @return Response
     */
    public function show($slug, TrickRepository $repo)
    {
        $trick =$repo->findOneBySlug($slug);
        return $this->render('trick/show.html.twig', [
            'trick' => $trick,
        ]);
    }

}
