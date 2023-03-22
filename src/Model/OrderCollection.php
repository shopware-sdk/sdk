<?php declare(strict_types=1);

namespace ShopwareSdk\Model;

class OrderCollection implements CollectionInterface
{
    /**
     * @var \ShopwareSdk\Model\Order[]
     */
    public array $entities = [];

    public function getClassMap()
    {
        return Order::class;
    }
}
