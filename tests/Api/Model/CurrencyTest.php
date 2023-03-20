<?php declare(strict_types=1);

namespace ShopwareSdk\Tests\Api\Model;

use PHPUnit\Framework\TestCase;
use ShopwareSdk\AdminAPI;
use ShopwareSdk\Model\Currency;
use ShopwareSdk\Model\Price;
use ShopwareSdk\Model\Product;
use ShopwareSdk\Model\Tax;
use ShopwareSdk\Tests\Api\ApiHelper;

class CurrencyTest extends TestCase
{
    public function testGetAll()
    {
        $currencyCollection = ApiHelper::createAdminApi()->currency->getAll();

    }
}
