<?php

namespace App\Controller;

use App\Entity\Trick;
use App\Form\TrickType;
use Doctrine\ORM\EntityManager;
use App\Repository\TrickRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\File\UploadedFile;
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
            foreach($form->get('images') as $image){
                /** @var UploadedFile $file */
                $file = $image->get('file')->getData();

                $destination = $this->getParameter('kernel.project_dir').'/public/uploads';

                $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                $newFilename = $originalFilename.'-'.uniqid().'.'.$file->guessExtension();
 
                // Impossible d'accèder à la fonction pour setter l'url car
                // nous sommes dans le form et non dans l'entity
                $image->getUrl()->setData($newFilename);

 
                $file->move(
                    $destination,
                    $newFilename
                );

                
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
