<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Trick;
use App\Entity\Comment;
use App\Form\TrickType;
use App\Form\CommentType;
use App\Service\UploaderHelper;
use App\Repository\UserRepository;
use App\Repository\TrickRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class TrickController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function home(TrickRepository $repo)
    {
        $tricks = $repo->findAll();

        return $this->render('trick/home.html.twig', [
            'tricks' => $tricks
        ]);
    }

    /**
     * @Route("/trick/new", name="trick_new")
     * @Route("/trick/edit/{slug}", name="trick_edit")
     *
     * @return Response
     */

    public function trickManagement(Request $request, $slug = false, TrickRepository $repo, UploaderHelper $uploaderHelper)
    {
        if ($slug !== false) {
            $trick = $repo->findOneBySlug($slug);
        } else {
            $trick = new Trick();
        }
        $form = $this->createForm(TrickType::class, $trick);
        $form->handleRequest($request);

        $manager = $this->getDoctrine()->getManager();

        if ($form->isSubmitted() && $form->isValid()) {
            foreach ($form->get('images') as $image) {
                
                /** @var UploadedFile $file */
                $file = $image->get('file')->getData();
                if ($file) {
                    $newFilename = $uploaderHelper->uploadTrickImage($file);

                    $imageEntity = $image->getData();
                    $imageEntity->setUrl($newFilename);
                }
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
    public function show(Request $request, $slug, TrickRepository $repo, UserRepository $userRepo)
    {
        $trick = $repo->findOneBySlug($slug);

        $comment = new Comment();

        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);

        $manager = $this->getDoctrine()->getManager();

        if ($form->isSubmitted() && $form->isValid()) {
            $userId = $this->getUser()->getId();
            $user = new User();
            $user = $userRepo->findOneById($userId);


            $comment->setAuthor($user);
            $comment->setTrick($trick);

            $manager->persist($comment);
            $manager->flush();

            return $this->redirectToRoute('trick_show', ['slug' => $trick->getSlug() ]);
        }

        return $this->render('trick/show.html.twig', [
            'trick' => $trick,
            'form' => $form->createView()
        ]);
    }
}
