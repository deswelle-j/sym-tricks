<?php

namespace App\Controller;

use App\Repository\TrickRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class TrickController extends AbstractController
{
    /**
     * @Route("/trick", name="trick")
     */
    public function index()
    {
        return $this->render('trick/index.html.twig', [
            'controller_name' => 'TrickController',
        ]);
    }

        /**
     * @Route("/trick/{id}", name="trick_show")
     * 
     * @return Response
     */
    public function show($id, TrickRepository $repo)
    {
        $trick =$repo->findOneById($id);
        return $this->render('trick/index.html.twig', [
            'trick' => $trick,
        ]);
    }
}
