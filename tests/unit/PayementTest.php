<?php

namespace App\Tests\Unit;

use App\Entity\Payement;
use App\Entity\Qrcode;
use App\Entity\OrdersDetails;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class PayementTest extends TestCase
{
    public function testAddOrdersDetail()
    {
        //entité avec des addOrdersDatails
        $payement = new Payement();
        $ordersDetails = new OrdersDetails();

        $payement->addOrdersDetail($ordersDetails);
        $this->assertTrue($payement->getOrdersDetails()->contains($ordersDetails));
    }

    public function testRemoveQrcode()
    {
        $payement = new Payement();
        $qrcode = new Qrcode();

        $payement->removeQrcode($qrcode);
        $this->assertFalse($payement->getQrcodes()->contains($qrcode));
    }
    
    public function testFailedRemoveQrcode()
    {
        $this->markTestIncomplete('failure');
        $this->expectException(InvalidArgumentException::class);
    
        $payement = new Payement();
        $qrcode = new Qrcode();

        $payement->removeQrcode($qrcode);
    }        
}