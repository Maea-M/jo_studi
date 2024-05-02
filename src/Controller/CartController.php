<?php

namespace App\Controller;

use App\Entity\Evenement;
use App\Repository\EvenementRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;


class CartController extends AbstractController
{
    #[Route('/cart', name: 'app_cart')]
    public function index(SessionInterface $session, EvenementRepository $evenementRepository)
    {
        $panier = $session->get("panier", []);

        // On "fabrique" les données à vide 
        $dataPanier = [];
        $total = 0;

        foreach($panier as $id => $quantite){
            $evenement = $evenementRepository->find($id);
            $dataPanier[] = [
                "evenement" => $evenement,
                "quantite" => $quantite
            ];
            if ($quantite == 2) {
                $total += $evenement->getPrice() * $quantite -5;
            }
            elseif ($quantite == 4) {
                $total += $evenement->getPrice() * $quantite -10;
            }
            else {
                $total += $evenement->getPrice() * $quantite;
            }
        }

        return $this->render('cart/index.html.twig', compact("dataPanier", "total"));
    }

    /* page pour ajouter un élément du panier*/
    #[Route('/add/{id}', name: 'app_cart_add')]
    public function add(Evenement $evenement, SessionInterface $session)
    {
        // On récupère le panier actuel
        $panier = $session->get("panier", []);
        $id = $evenement->getId();

        if(!empty($panier[$id])){
            $panier[$id]++;
        }else{
            $panier[$id] = 1;
        }

        // On sauvegarde dans la session
        $session->set("panier", $panier);

        return $this->redirectToRoute('app_cart');
    }

    /* page pour ajouter un élément du panier*/
    #[Route('/remove/{id}', name: 'app_cart_remove')]
    public function remove(Evenement $evenement, SessionInterface $session)
    {
        // On récupère le panier actuel
        $panier = $session->get("panier", []);
        $id = $evenement->getId();

        if(!empty($panier[$id])){
            if($panier[$id] > 1){
                $panier[$id]--;
            }else{
                unset($panier[$id]);
            }
        }

        // On sauvegarde dans la session
        $session->set("panier", $panier);

        return $this->redirectToRoute('app_cart');
    }

    // on supprime le panier
    #[Route('/delete/{id}', name: 'app_cart_delete')]

    public function delete(Evenement $evenement, SessionInterface $session)
    {
        // On récupère le panier actuel
        $panier = $session->get("panier", []);
        $id = $evenement->getId();

        if(!empty($panier[$id])){
            unset($panier[$id]);
        }

        // On sauvegarde dans la session
        $session->set("panier", $panier);

        return $this->redirectToRoute('app_cart');
    }

    // route pour vider le panier
    #[Route('/deleteAll', name: 'app_cart_delete_all')]
    public function deleteAll(SessionInterface $session)
    {
        $session->remove("panier");

        return $this->redirectToRoute('app_cart');
    }

}
