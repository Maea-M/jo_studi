<?php

namespace App\Controller;

use App\Repository\EvenementRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class PageController extends AbstractController
{
    #[Route('/', name: 'app_home')]

    public function home(EvenementRepository $evenementRepository, ParameterBagInterface $parameterBagInterface): Response
    {
        $limit = $parameterBagInterface->get('home_evenement_limit');
        $evenements = $evenementRepository->findBy([], ['id'=>'DESC'], $limit);

        return $this->render('page/index.html.twig', [
            'controller_name' => 'PageController',
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
