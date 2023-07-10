<?php
namespace App\DataFixtures;
  
use App\Entity\Product;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture; 

class ProductLoader extends Fixture
{
   

    public function load(ObjectManager $manager)
    {
        // Ürünleri oluştur
        $products = [
            [
                'name' => 'Ürün 1',
                'price' => 10.99,
            ],
            [
                'name' => 'Ürün 2',
                'price' => 20.99,
            ],
            [
                'name' => 'Ürün 3',
                'price' => 30.99,
            ],
            // Diğer ürünler...
        ];

        foreach ($products as $productData) {
            $product = new Product();
            $product->setName($productData['name']);
            $product->setPrice($productData['price']);

            $manager->persist($product);
        }

        $manager->flush();
    }
}