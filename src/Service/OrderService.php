<?php declare(strict_types=1);

namespace ShopwareSdk\Service;

use ShopwareSdk\Model\OrderCollection;
use ShopwareSdk\Model\Product;

class OrderService extends AbstractService
{
    private const URL = '/api/order/';


    public function all($options = [])
    {
        return $this->request('GET', self::URL, OrderCollection::class, null, $options);
    }
}
