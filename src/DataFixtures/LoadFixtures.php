<?php

namespace App\DataFixtures;

use App\Entity\Product;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;

class LoadFixtures extends Fixture
{

    private $faker;

    public function load(ObjectManager $manager) {

        $this->faker = Factory::create();
        $this->addProduct($manager);
    }

    private function addProduct(ObjectManager $em) {

        for ($i = 1; $i <= 10; $i++) {
            $product = new Product();
            $product->setName($this->faker->jobTitle());
            $product->setPrice($this->faker->numberBetween(1, 100));
            $product->setCreatedAt();

            $this->setReference('product_' . $i, $product);
            $em->persist($product);
        }

        $em->flush();
    }
}