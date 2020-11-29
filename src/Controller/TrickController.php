<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Trick;
use App\Entity\Comment;
use App\Form\TrickType;
use App\Form\CommentType;
use App\Repository\CommentRepository;
use App\Service\UploaderHelper;
use App\Repository\UserRepository;
use App\Repository\TrickRepository;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Csrf\CsrfToken;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\HttpFoundation\File\UploadedFile;

use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Serializer\Normalizer\GetSetMethodNormalizer;

class TrickController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function home(TrickRepository $repo)
    {
        $tricks = $repo->findBy([], [], 10, 0);

        $count = count($repo->findAll());
        $pages = ceil($count / 10); 


        return $this->render('trick/home.html.twig', [
            'tricks' => $tricks,
            'pages' => $pages
        ]);
    }

    /**
     * @Route("/load/{page}", name="load_more")
     */
    public function loadTricks(TrickRepository $repo, $page)
    {
        $limit = 10;
        $page = $page -1;
        $offset = ($page * $limit);

        $tricks = $repo->findBy([], [], $limit, $offset);

        $serializer = new Serializer([new ObjectNormalizer()]);
        $tricks = $serializer->normalize($tricks, 'json', 
            [AbstractNormalizer::ATTRIBUTES => 
                [
                    'id',
                    'title',
                    'slug',
                    'groupTrick' => ['name'],
                    'images' => ['url']
                    ]
                ]
        );
        
        return new JsonResponse([
                'view' => $this->renderView('trick/tricksLoad.html.twig', [
                        'tricks' => $tricks,
                    ]),
                    'offset' => 3
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
                    $newFilename = $uploaderHelper->uploadImage($file);

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
     * @Route("/trick/delete/{id}", name="trick_delete")
     */
    public function delete($id, Request $request, TrickRepository $repo, CsrfTokenManagerInterface $csrfTokenManager)
    {
        $token = new CsrfToken('delete', $request->query->get('_csrf_token'));

        if (!$csrfTokenManager->isTokenValid($token)) {
            throw $this->createAccessDeniedException('Token CSRF invalide');
        }

        $trick = $repo->findOneById($id);

        $manager = $this->getDoctrine()->getManager();

        $manager->remove($trick);
        $manager->flush();

        return $this->redirectToRoute('home');
    }

    /**
     * @Route("/trick/detail/{slug}", name="trick_show")
     *
     * @return Response
     */
    public function show(Request $request, $slug, TrickRepository $trickRepo,CommentRepository $commentRepo, UserRepository $userRepo)
    {
        $trick = $trickRepo->findOneBySlug($slug);

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

        $comments = $commentRepo->findByTrick($trick->getId());

        return $this->render('trick/show.html.twig', [
            'trick' => $trick,
            'comments' =>$comments,
            'form' => $form->createView()
        ]);
    }
}
