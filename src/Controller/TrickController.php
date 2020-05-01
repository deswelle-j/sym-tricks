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
     * @Route("/trick/{slug}/edit", name="trick_edit")
     * 
     * @return Response
     */

    public function trickManagement(Request $request, $slug = false, TrickRepository $repo)
    {
        if($slug !== false) {
            $trick = $repo->findOneBySlug($slug);
        } else {
            $trick = new Trick();
        }
        $form = $this->createForm(TrickType::class, $trick);

        $form->handleRequest($request);

        $manager = $this->getDoctrine()->getManager();
        if($form->isSubmitted() && $form->isValid()) {
            foreach($trick->getImages() as $image) {
                $image->setTrick($trick);
                $manager->persist($image);
            }
            
            $manager->persist($trick);

            $manager->flush();

            return $this->redirectToRoute('trick_show', ['slug' => $trick->getSlug() ]);
        }

        return $this->render('trick/form.html.twig', [
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
        $trick = $repo->findOneBySlug($slug);
        return $this->render('trick/show.html.twig', [
            'trick' => $trick,
        ]);
    }

}
