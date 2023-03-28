<?php declare(strict_types=1);

namespace ShopwareSdk\Service;

use ShopwareSdk\Model\Order\Order;
use ShopwareSdk\Model\Order\OrderCollection;

class OrderService extends AbstractService
{
    private const URL = '/api/order/';


    public function all($options = [])
    {
        return $this->request('GET', self::URL, OrderCollection::class, null, $options);
    }

    public function get(string $id)
    {
        return $this->request('GET', self::URL . $id, Order::class, null);
    }
}
