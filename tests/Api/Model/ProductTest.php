<?php declare(strict_types=1);

namespace ShopwareSdk\Tests\Api\Model;

use PHPUnit\Framework\TestCase;
use ShopwareSdk\Model\Price;
use ShopwareSdk\Model\Product;
use ShopwareSdk\Tests\ApiHelper;

class ProductTest extends TestCase
{
    private string $productId;

    protected function setUp(): void
    {
        parent::setUp();

        $this->productId = md5('product' . 'TEST-PRODUCT123');
    }

    protected function tearDown(): void
    {
        try {
            ApiHelper::createAdminApi()->product->delete($this->productId);
        } catch (\Exception $e) {

        }

        parent::tearDown();
    }

    public function testProductNotFound()
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionCode(404);

        ApiHelper::createAdminApi()->product->get('1');
    }

    public function testMessageWhenProductNotFound()
    {
        try {
            ApiHelper::createAdminApi()->product->get('1');
        } catch (\Exception $e) {
            $msg = json_decode($e->getMessage(), true);
            self::assertSame('Not Found', $msg[0]['title']);
            self::assertSame('404', $msg[0]['status']);
            return;
        }

        $this->fail();

    }

    public function testCreateProduct()
    {
        $adminApi = ApiHelper::createAdminApi();

        $product = $this->getProduct($adminApi);

        $adminApi->product->create($product);

        $checkProduct = $adminApi->product->get($this->productId);

        self::assertSame($this->productId, $checkProduct->id);
        self::assertSame($product->taxId, $checkProduct->taxId);
        self::assertSame($product->productNumber, $checkProduct->productNumber);
        self::assertSame($product->stock, $checkProduct->stock);
        self::assertSame($product->name, $checkProduct->name);
        self::assertSame($product->description, $checkProduct->description);
        self::assertSame($product->isCloseout, $checkProduct->isCloseout);

        self::assertCount(1, $checkProduct->price);
        self::assertSame($product->price[0]->currencyId, $checkProduct->price[0]->currencyId);
        self::assertSame($product->price[0]->gross, $checkProduct->price[0]->gross);

        $adminApi->product->delete($this->productId);

        try {
            $adminApi->product->get($this->productId);
        } catch (\Exception $e) {
            self::assertSame(404, $e->getCode());
            return;
        }

        $this->fail('Product not deleted. (Code 404 expected)');
    }

    /**
     * @param \ShopwareSdk\AdminAPI $adminApi
     *
     * @return \ShopwareSdk\Model\Product
     */
    private function getProduct(\ShopwareSdk\AdminAPI $adminApi): Product
    {
        $product = new Product();

        $product->id = $this->productId;
        $product->taxId = $adminApi->tax->getAll()->entities[0]->id;
        $product->name = 'Test Product';
        $product->stock = 99;
        $product->description = 'Test Product Description';
        $product->productNumber = 'TEST-PRODUCT123';
        $product->isCloseout = false;

        $currencyList = $adminApi->currency->getAll()->entities;
        $currencyId = null;
        foreach ($currencyList as $item) {
            if ($item->isoCode === 'EUR') {
                $currencyId = $item->id;
            }
        }

        $price = new Price();
        $price->currencyId = $currencyId;
        $price->net = 100;
        $price->gross = 110;
        $price->linked = false;

        $product->price = [$price];
        return $product;
    }
}
