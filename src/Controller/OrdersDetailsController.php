<?php

namespace App\Controller;

use App\Repository\OrdersDetailsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Entity\OrdersDetails;


class OrdersDetailsController extends AbstractController
{
    #[Route('/orders/details', name: 'app_orders_details')]
    public function index(OrdersDetailsRepository $ordersDetailsRepository): Response
    {
        $ordersDetails = $ordersDetailsRepository->findAll();
        return $this->render('orders_details/index.html.twig', [
            'ordersDetails' => $ordersDetails,
            /*dd($ordersDetails)*/
        ]);
    }
}
