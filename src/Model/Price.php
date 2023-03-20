<?php declare(strict_types=1);

namespace ShopwareSdk\Model;

class Price
{
    public string|null $currencyId;
    public Currency|null $currency;

    public float|null $net;
    public float|null $gross;
    public bool|null $linked;
}
