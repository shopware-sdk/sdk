<?php declare(strict_types=1);

namespace ShopwareSdk\Tests\Api\Model;

use PHPUnit\Framework\TestCase;
use ShopwareSdk\AdminAPI;
use ShopwareSdk\Model\Currency;
use ShopwareSdk\Model\Price;
use ShopwareSdk\Model\Product;
use ShopwareSdk\Model\TaxCollection;
use ShopwareSdk\Tests\Api\ApiHelper;

class ProductTest extends TestCase
{
    public function testProductNotFound()
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('No route found for "GET https://127.0.0.1:8000/api/product/1"');
        $this->expectExceptionCode(404);

        ApiHelper::createAdminApi()->product->get('1');
    }

    public function testCreateProduct()
    {
        $adminApi = ApiHelper::createAdminApi();


        $product = new Product();
        $product->taxId = $adminApi->tax->getAll()->entities[0]->id;
        $product->name = 'Test Product';
        $product->stock = 99;
        $product->description = 'Test Product Description';
        $product->isCloseout = false;
        $product->productNumber = 'TEST-PRODUCT';

        $price = new Price();
        $price->currencyId = $adminApi->currency->getAll()->entities[0]->id;
        $price->net = 100;
        $price->gross = 110;
        $price->linked = true;

        $product->price = $price;

        ApiHelper::createAdminApi()->product->create($product);
    }
}
