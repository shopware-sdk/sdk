<?php declare(strict_types=1);

namespace ShopwareSdk\Tests\Unit\Model;

use PHPUnit\Framework\TestCase;
use ShopwareSdk\AdminApi;
use ShopwareSdk\Tests\ApiHelper;
use ShopwareSdk\Tests\ClientSpy;

final class ProductTest extends TestCase
{
    public function testGet()
    {
        $clientSpy = new ClientSpy([
            '/api/product/11dc680240b04f469ccba354cbf0b967' => json_decode(file_get_contents(__DIR__ . '/product_response.json'), true),
        ]);
        $adminApi = new AdminApi(ApiHelper::getConfig(), $clientSpy);
        $product = $adminApi->product->get('11dc680240b04f469ccba354cbf0b967');

        self::assertSame('11dc680240b04f469ccba354cbf0b967', $product->id);
        self::assertSame('3eea0cb623fd45df86a12198da08ea6f', $product->taxId);
        self::assertSame('SWDEMO10002', $product->productNumber);
        self::assertSame(10, $product->stock);
        self::assertSame('Main product with advanced prices', $product->name);
        self::assertSame('Lorem ipsum dolor sit amet, consetetur sadipscing elitr', $product->description);
        self::assertSame(false, $product->isCloseout);

        self::assertCount(1, $product->price);
        self::assertSame('b7d2554b0ce847cd82f3ac9bd1c0dfca', $product->price[0]->currencyId);
        self::assertSame(798.0, $product->price[0]->net);
        self::assertSame(950.0, $product->price[0]->gross);
        self::assertSame(true, $product->price[0]->linked);
      ;
    }
}
