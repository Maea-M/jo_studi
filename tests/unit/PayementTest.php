<?php

namespace App\Tests\Unit;

use App\Entity\Payement;
use App\Entity\Qrcode;
use App\Entity\OrdersDetails;
use PHPUnit\Framework\TestCase;

class PayementTest extends TestCase
{
    public function testPayement()
    {
        //entité avec des addOrdersDatails et removeOrdersDetails idem avec qr code
        $payement = new Payement();
        $qrcode = new Qrcode();
        $ordersDetails = new OrdersDetails();

        // Test avec OrdersDetails
        $payement->addOrdersDetail($ordersDetails);
        $this->assertTrue($payement->getOrdersDetails()->contains($ordersDetails));

        // Test avec QR cOde
        $payement->removeQrcode($qrcode);
        //$this->assertFalse($qrcode->getPayement()->contains(null));
        $this->assertFalse($payement->getQrcodes()->contains($qrcode));
    }
}