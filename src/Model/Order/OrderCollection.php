<?php declare(strict_types=1);

namespace ShopwareSdk\Model\Order;

use ShopwareSdk\Model\CollectionInterface;

class OrderCollection implements CollectionInterface
{
    /**
     * @var \ShopwareSdk\Model\Order\Order[]
     */
    public array $entities = [];

    public function getClassMap()
    {
        return Order::class;
    }
}
