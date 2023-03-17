<?php declare(strict_types=1);

namespace ShopwareSdk\Service;

use ShopwareSdk\Model\Product;

class ProductService extends AbstractService
{
    private const URL = '/api/product/';
    public function get(string $id)
    {
        return $this->request('GET', self::URL . $id, Product::class);
    }

    public function create(Product $product)
    {
        return $this->request('POST', self::URL, Product::class, $product);
    }
}
