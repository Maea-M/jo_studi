<?php

namespace App\Controller;

use App\Entity\Evenement;
use App\Repository\EvenementRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Attribute\Route;

class EvenementController extends AbstractController
{
    /*Page pour afficher tous les évènements sportifs par ordre*/
    #[Route('/evenement', name: 'app_evenement')]
    public function index(EvenementRepository $evenementRepository): Response
    {
        $evenements = $evenementRepository->findBy([], ['id'=>'DESC']);
        return $this->render('evenement/index.html.twig', [
            'evenements' => $evenements,
        ]);
    }

    /*Page pour afficher 1 seul évnemenent en grand*/
    #[Route('/evenements/{id}', name: 'app_evenement_show')]
    public function show(Evenement $evenement): Response
    {
        return $this->render('evenement/show.html.twig', [
            'evenement' => $evenement,
        ]);
    }

}
