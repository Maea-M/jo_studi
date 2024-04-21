<?php

namespace App\Controller;

use App\Entity\Orders;
use App\Entity\OrdersDetails;
use App\Entity\Payement;
use App\Form\PayementFormType;
use App\Repository\OrdersDetailsRepository;
use App\Repository\OrdersRepository;
use App\Repository\PayementRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Response;
use Stripe\Stripe;
use Stripe\Checkout\Session;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Http\Attribute\IsGranted;





class PayementController extends AbstractController {

    #[IsGranted('ROLE_USER')]
    #[Route('/payement', name: 'app_payement', methods: ['GET', 'POST'])]
    public function index(Request $request, EntityManagerInterface $entityManager, OrdersDetails $ordersDetails): Response
    {
        $user = $this->getUser();
        $ordersDetails = $this->getParameter();
        $payement = new Payement();
        $form = $this->createForm(PayementFormType::class, $payement);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            // trouver l'utilisateur lié au paiement
            $payement->setUser($user);
            //trouver les paiements non faits
            $payement->setOrdersDetails($ordersDetails);
            $ordersDetails->getId();
            $ordersDetails->setIsPaid(true);
            
            //dd($oD);

            //changer la bdd
            $payement->setIsPaid(true);
            $payement->setSecondKey(uniqid());

            $entityManager->persist($payement);
            $entityManager->persist($ordersDetails);

            $entityManager->flush();

            return $this->redirectToRoute('success_url');
        }

        return $this->render('payement/index.html.twig', [
        'payement' => $payement,
        'form' => $form->createView(),
    ]);
    }

    #[Route('/success-url', name: 'success_url')]
    public function successUrl(): Response
    {
        return $this->render('payement/success.html.twig', []);
    }


    #[Route('/cancel-url', name: 'cancel_url')]
    public function cancelUrl(): Response
    {
        return $this->render('payement/cancel.html.twig', []);
    }
/*
    #[Route('orders/checkout/', name: 'app_checkout')]
    public function checkout($stripeSK, OrdersDetailsRepository $ordersDetailsRepository, SessionInterface $session): Response
    {
        $commande= $session->get('commande', []);
        foreach($commande as $item => $price){
            $ordersDetails = $ordersDetailsRepository->find($item);
            $priceStripe =$ordersDetails->getPrice();

        Stripe::setApiKey($stripeSK);

        $session = Session::create([
            'payment_method_types' => ['card'],
            'line_items'           => [
                [
                    'price_data' => [
                        'currency'     => 'EUR',
                        'amount' => $priceStripe * 100 ,
                    ],                
                ]
            ],
            'mode' => 'payment',     
            'success_url' => $this->generateUrl('success_url', [], UrlGeneratorInterface::ABSOLUTE_URL),
            'cancel_url'  => $this->generateUrl('cancel_url', [], UrlGeneratorInterface::ABSOLUTE_URL),
        ]);
        }
        /*return $this->redirect($session->url, 303);*/
    /*}*/
    
}