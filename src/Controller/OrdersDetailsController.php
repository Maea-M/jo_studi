<?php

namespace App\Controller;

use App\Repository\OrdersDetailsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Entity\OrdersDetails;
use App\Entity\User;
use App\Repository\OrdersRepository;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Component\Security\Http\Tests\Fixtures\IsGrantedAttributeController;

class OrdersDetailsController extends AbstractController
{
    #[IsGranted('ROLE_USER')]
    #[Route('/orders/details', name: 'app_orders_details')]
    public function index(OrdersDetailsRepository $ordersDetailsRepository): Response
    {
        $user = $this->getUser();

        $ordersDetails = $ordersDetailsRepository->findBy(['IsPaid' => false]);
        return $this->render('orders_details/index.html.twig', [
            'ordersDetails' => $ordersDetails,
        ]);
    }
}
