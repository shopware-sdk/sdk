<?php declare(strict_types=1);

namespace ShopwareSdk\Tests\Api\Model;

use PHPUnit\Framework\TestCase;
use ShopwareSdk\AdminAPI;
use ShopwareSdk\Model\Currency;
use ShopwareSdk\Model\Price;
use ShopwareSdk\Model\Product;
use ShopwareSdk\Model\TaxCollection;
use ShopwareSdk\Tests\Api\ApiHelper;

class OrderTest extends TestCase
{
    public function testOrder()
    {
        $orders = ApiHelper::createAdminApi()->order->all();
    }

}
