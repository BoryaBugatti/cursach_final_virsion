<?php

namespace App\DataFixtures;
use App\Entity\Orders;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $connection = $manager->getConnection();
        $connection->executeStatement('TRUNCATE TABLE product RESTART IDENTITY CASCADE');
        
        $faker = Factory::create();
        for ($i = 0; $i < 10; $i++){
            $order = new Orders();
            $order->setOrderClientName($faker->name);
            $order->setOrderAddress($faker->address);
            $order->setOrderWasteType($faker->word());
            $order->setOrderDate($faker->dateTime());
            $order->setOrderTime($faker->dateTime);
            $order->setOrderWasteVolume($faker->randomFloat(2, 10, 100));
            $manager->persist($order);
        }
        $manager->flush();
    }
}