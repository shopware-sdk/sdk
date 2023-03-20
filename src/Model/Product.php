<?php declare(strict_types=1);

namespace ShopwareSdk\Model;

class Product
{
    public string|null $id;

    public string|null $taxId;

    public Price|null $price;

    public string|null $productNumber;
    public int|null $stock;
    public string|null $name;
    public string|null $description;
    public bool|null $isCloseout;
}
