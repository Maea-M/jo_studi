<?php

namespace App\Controller;

use App\Repository\EvenementRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class PageController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function home(EvenementRepository $evenementRepository): Response
    {
        $evenements = $evenementRepository->findBy([], ['id'=>'DESC'], 3);
        return $this->render('page/index.html.twig', [
            'controller_name' => 'PageController',
            'evenements'=>$evenements,
        ]);
    }

    #[Route('/mentions', name: 'app_mentionslegales')]
    public function mentions(): Response
    {
        return $this->render('page/mentions.html.twig', [
            'controller_name' => 'PageController',
        ]);
    }

    #[Route('/profil', name: 'app_profil')]
    public function profil(): Response
    {
        return $this->render('page/profil.html.twig', [
            'controller_name' => 'PageController',
        ]);
    }
}
