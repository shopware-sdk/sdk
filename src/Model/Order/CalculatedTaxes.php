<?php declare(strict_types=1);

namespace ShopwareSdk\Model\Order;

class CalculatedTaxes
{
    public float|null $tax;
    public float|null $taxRate;
    public float|null $price;
}
