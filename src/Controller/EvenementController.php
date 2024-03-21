<?php

namespace App\Controller;

use App\Entity\Evenement;
use App\Repository\EvenementRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class EvenementController extends AbstractController
{
    #[Route('/evenement', name: 'app_evenement')]
    public function index(EvenementRepository $evenementRepository): Response
    {
        $evenements = $evenementRepository->findBy([], ['id'=>'DESC']);
        dump($evenements);
        return $this->render('evenement/index.html.twig', [
            'evenements' => $evenements,
        ]);
    }

    #[Route('/evenements/{id}', name: 'app_evenement_show')]
    public function show(Evenement $evenement, Request $request, EntityManagerInterface $entityManager, 
                        Security $security,SessionInterface $session): Response
    {
        return $this->render('evenement/show.html.twig', [
            'controller_name' => 'EvenementController',
        ]);
    }
}
