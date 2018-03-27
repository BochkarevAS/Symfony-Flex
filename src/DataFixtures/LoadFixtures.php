<?php

namespace App\DataFixtures;

use App\Entity\Product;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class LoadFixtures extends Fixture
{

    private $faker;
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder) {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager) {

        $this->faker = Factory::create();
        $this->addProduct($manager);
        $this->addSecurity($manager);
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

    private function addSecurity(ObjectManager $em) {

        for ($i = 1; $i <= 10; $i++) {
            $user = new User();
//            $user->setEmail($this->faker->email());
            $user->setEmail($i);
            $password = $this->encoder->encodePassword($user, '111');
            $user->setPassword($password);

            $this->setReference('user_' . $i, $user);
            $em->persist($user);
        }

        $em->flush();
    }

}