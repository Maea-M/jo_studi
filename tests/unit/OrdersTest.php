<?php

namespace App\Tests;

use App\Entity\Orders;
use App\Entity\User;

use PHPUnit\Framework\TestCase;

class OrdersUnitTest extends TestCase
{
    public function testGetSetUser(): void
    {
        $order = new Orders();
        $user = new User();

        $this->assertEmpty($order->getUser());

        $order->setUser($user);
        $this->assertSame($user, $order->getUser());
        $this->assertNotSame(null, $order->getUser());
    }
}