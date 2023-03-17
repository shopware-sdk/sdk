<?php declare(strict_types=1);

namespace ShopwareSdk\Tests\Api\Model;

use PHPUnit\Framework\TestCase;
use ShopwareSdk\AdminAPI;

class ProductTest extends TestCase
{
    public function testProductNotFound()
    {
        $config = [
            'apiUrl' => $_ENV['API_URL'],
            'client_id' => $_ENV['CLIENT_ID'] ,
            'client_secret' => $_ENV['CLIENT_SECRET'],
        ];
        $adminApi = new AdminAPI($config);

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('No route found for "GET https://127.0.0.1:8000/api/product/1"');
        $this->expectExceptionCode(404);

        $adminApi->product->get('1');
    }
}
