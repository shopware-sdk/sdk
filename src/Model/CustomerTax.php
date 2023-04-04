<?php declare(strict_types=1);

namespace ShopwareSdk\Model;

class CustomerTax
{
    public string|null $currencyId;
    public int|null $amount;
    public bool|null $enabled;
}
