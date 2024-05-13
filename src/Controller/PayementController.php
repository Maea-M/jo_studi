<?php

namespace App\Controller;

use App\Entity\OrdersDetails;
use App\Entity\Payement;
use App\Form\PayementFormType;
use App\Repository\OrdersDetailsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Response;
use Stripe\Stripe;
use Stripe\Checkout\Session;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Http\Attribute\IsGranted;





class PayementController extends AbstractController {

    #[IsGranted('ROLE_USER')]
    #[Route('/payement/', name: 'app_payement')]
    public function index(Request $request, EntityManagerInterface $entityManager,
    #[MapEntity] ?OrdersDetails $ordersDetails, OrdersDetailsRepository $ordersDetailsRepository ): Response
    {
        //chercher l'utilisateur
        $user = $this->getUser();

        //instancier un nouveau paiement
        $payement = new Payement();
        $form = $this->createForm(PayementFormType::class, $payement);
        $form->handleRequest($request);
        
        //création du formulaire
        if ($form->isSubmitted() && $form->isValid()) {
            // trouver l'utilisateur lié au paiement
            $payement->setUser($user);
            
            //trouver les paiements non faits
            $ordersDetails = $ordersDetailsRepository->findBy(['IsPaid'=>false]);

            foreach($ordersDetails as $orderDetail){
                $orderDetail->setPayement($payement);
                $orderDetail->setIsPaid(true);
                $entityManager->persist($orderDetail);
            }
            $payement->setSecondKey(uniqid());
            $payement->setIsPaid(true);
                
            $entityManager->persist($payement);
            $entityManager->flush();

            return $this->redirectToRoute('app_qrcode', [], Response::HTTP_SEE_OTHER);
        }

    return $this->render('payement/index.html.twig', [
        'payement' => $payement,
        'form' => $form->createView(),
    ]);
    }

    //#[Route('/success-url', name: 'success_url')]
    //public function successUrl(): Response
    //{
    //    return $this->render('payement/success.html.twig', []);
    //}


    //#[Route('/cancel-url', name: 'cancel_url')]
    //public function cancelUrl(): Response
    //{
    ///    return $this->render('payement/cancel.html.twig', []);
    //}
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