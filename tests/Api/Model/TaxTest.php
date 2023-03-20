<?php declare(strict_types=1);

namespace ShopwareSdk\Tests\Api\Model;

use PHPUnit\Framework\TestCase;
use ShopwareSdk\AdminAPI;
use ShopwareSdk\Model\Currency;
use ShopwareSdk\Model\Price;
use ShopwareSdk\Model\Product;
use ShopwareSdk\Model\Tax;
use ShopwareSdk\Tests\Api\ApiHelper;

class TaxTest extends TestCase
{
    public function testGetAll()
    {
        $taxCollection = ApiHelper::createAdminApi()->tax->getAll();

        self::assertCount(3, $taxCollection->entities);

        self::assertInstanceOf(Tax::class, $taxCollection->entities[0]);
        self::assertSame('5c025a831a584fc0add209b81517e69d', $taxCollection->entities[0]->id);
        self::assertSame(19.0, $taxCollection->entities[0]->taxRate);
        self::assertSame('Standard rate', $taxCollection->entities[0]->name);
        self::assertSame(1, $taxCollection->entities[0]->position);

        self::assertInstanceOf(Tax::class, $taxCollection->entities[1]);
        self::assertSame('7fdbc3f0c0664c6bb8d96bd5c93dfd40', $taxCollection->entities[1]->id);
        self::assertSame(7.0, $taxCollection->entities[1]->taxRate);
        self::assertSame('Reduced rate', $taxCollection->entities[1]->name);
        self::assertSame(2, $taxCollection->entities[1]->position);

        self::assertInstanceOf(Tax::class, $taxCollection->entities[2]);
        self::assertSame('beacebf5ce694b79b0df78224beb26c0', $taxCollection->entities[2]->id);
        self::assertSame(0.0, $taxCollection->entities[2]->taxRate);
        self::assertSame('Reduced rate 2', $taxCollection->entities[2]->name);
        self::assertSame(3, $taxCollection->entities[2]->position);
    }
}
