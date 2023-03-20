<?php declare(strict_types=1);

namespace ShopwareSdk\Model;

class Currency
{
    public string|null $id;
    public float|null $factor;
    public string|null $symbol;
    public string|null $isoCode;
    public string|null $shortName;
    public string|null $name;

    public ItemRounding|null $itemRounding;
    public TotalRounding|null $totalRounding;
}
