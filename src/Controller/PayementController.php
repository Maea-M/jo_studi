<?php

namespace App\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Attribute\Route;
use Stripe\Stripe;
use Stripe\Checkout\Session;
require_once '../vendor/autoload.php';
require_once '../secrets.php';



class PayementController extends AbstractController {

    #[Route('/payement', name: 'app_payement')]

    public function __construct(readonly private string $clientSecret) {
        Stripe::setApiKey($this->$clientSecret);
        Stripe::setApiVersion(2024-04-10);
    }

    public function payement(){
        $session = Session::create([
            'mode' => 'payment',
            'success_url' => 'http://localhost:8000/success.html',
            'cancel_url' => 'http://localhost:8000/cancel.html',
        ]

        );

    }
}

