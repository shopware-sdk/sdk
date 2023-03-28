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
        $this->request('POST', self::URL, null, $product);
    }

    public function update(Product $product)
    {
        $this->request('PATCH', self::URL . $product->id, null, $product);
    }

    public function delete(string $id)
    {
        $this->request('DELETE', self::URL . $id);
    }
}
