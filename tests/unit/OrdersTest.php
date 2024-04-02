use App\Entity\Orders;

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

    public function testGetSetOrdersDetails(): void
    {
        $order = new Orders();
        $ordersDetails = new OrdersDetails();

        $this->assertEmpty($order->getOrdersDetails());

        $order->setOrdersDetails($ordersDetails);
        $this->assertSame($ordersDetails, $order->getOrdersDetails());
        $this->assertNotSame(null, $order->getOrdersDetails());
    }   
}