<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\EvenementRepository;
use App\Entity\Orders;
use App\Entity\OrdersDetails;
use Doctrine\ORM\EntityManagerInterface;

class OrdersController extends AbstractController
{
    /* NE FONCTIONNE PAS PrOBLEME DE SERVICES???
    #[Route('/orders_payement', name: 'app_orders_payement')]
    public function index(Request $request, OrdersDetailsRepository $ordersDetailsRepository, ordersDetails $ordersDetails): Response
    {
        $ordersDetails = $ordersDetailsRepository->findAll();
        $this->$request->getPrice();
        $this->$request->getEvenement();

        return $this->render('orders/index.html.twig', [
            'ordersDetails' => $ordersDetails,
        ]);
    }
*/
    #[Route('/orders', name: 'app_orders')]
    public function add(SessionInterface $session, EvenementRepository $evenementRepository, EntityManagerInterface $em): Response
    {
        // vérifier que l'utilisateur est connecté
        $this->denyAccessUnlessGranted('ROLE_USER');

        $panier= $session->get('panier', []);

        if ($panier === []){
            $this->addFlash('message', 'votre panier est vide');
            return $this->redirectToRoute('app_home');
        }

         //Le panier n'est pas vide, on crée la commande
        $order = new Orders();

         // On remplit la commande
        $order->setUser($this->getUser());
        $order->setReference(uniqid());

         // On parcourt le panier pour créer les détails de commande
        foreach($panier as $item => $quantity){
            $orderDetails = new OrdersDetails();

             // On va chercher le produit et il faut qu'il soit toujours en stock
            $evenement = $evenementRepository->find($item);
            $place =$evenement->getPlace();
            if ($quantity > $place) {
                $this->addFlash('message', 'Désolé, nous n\'avons pas assez de stock');
                return $this->redirectToRoute('app_home');
            }
            else {
                $price = $evenement->getPrice();
                $place = $place - $quantity;
                $evenement->setPlace($place);

             // On crée le détail de commande
                $orderDetails->setEvenement($evenement);
                $orderDetails->setPrice($price);
                $orderDetails->setQuantity($quantity);
                $order->addOrdersDetail($orderDetails);

            }
        }

         // On persiste et on flush
        $em->persist($order);
        $em->flush();

        $session->remove('panier');
        
        $this->addFlash('message', 'Commande créée avec succès');
        return $this->redirectToRoute('app_orders_details');
    }

}