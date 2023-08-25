<?php

namespace App\DataFixtures;

use App\Entity\Order;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

class OrderFixtures extends Fixture
{
    private $projectRoot;
    private $serializer;

    public function __construct(string $projectRoot, DenormalizerInterface $serializer)
    {
        $this->projectRoot = $projectRoot;
        $this->serializer = $serializer;
    }

    public function load(ObjectManager $manager): void
    {
        $orderRepository = $manager->getRepository(Order::class);
        $ordersJson = file_get_contents($this->projectRoot."/json/orders.json");
        $ordersArray = json_decode($ordersJson, true);
        foreach ($ordersArray as $orderItem) {
            $order = $this->serializer->denormalize($orderItem, Order::class, 'array');
            $orderExists = $orderRepository->findOneBy(
                [
                    'customer' => $order->getCustomer(),
                    'date' => $order->getDate(),
                    'status' => $order->getStatus(),
                    'amount' => $order->getAmount()
                ]
            );
            if (!$orderExists) {
                $orderRepository->addOrder($order);
            }
        }

    }
}
