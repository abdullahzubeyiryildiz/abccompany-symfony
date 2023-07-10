<?php
namespace App\DataFixtures;
 
use App\Entity\User;
use App\Entity\Order;
use App\Entity\Product;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture; 

class ProductOrderLoader extends Fixture
{
   

    public function load(ObjectManager $manager)
    {
        $userRepository = $manager->getRepository(User::class);
        $productRepository = $manager->getRepository(Product::class);

        $users = $userRepository->findAll();
        $productIds = [1, 2, 3]; // Ürün id'lerini buraya ekleyin

        foreach ($productIds as $key => $productId) {
            $product = $productRepository->find($productId);
            if ($product) {
                $order = new Order();
                $orderCode = ($key === 0) ? 'ORD-1688896578' : 'ORD-' . time();
                $order->setOrderCode($orderCode);
                $order->setUser($this->getRandomUser($users));
                $order->setProduct($product);
                $order->setQuantity(2);
                $order->setAddress('User Adres');
                $order->setShippingDate(new \DateTime());

                $manager->persist($order);
            }
        }

        $manager->flush();
    }

    private function getRandomUser(array $users): ?User
    {
        return $users[array_rand($users)];
    }
}