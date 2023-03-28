<?php declare(strict_types=1);

namespace ShopwareSdk\Model\Order;


class Price
{
    public float|null $netPrice;
    public float|null $totalPrice;

    /**
     * @var \ShopwareSdk\Model\Order\CalculatedTaxes[]|null
     */
    public array|null $calculatedTaxes;

    /**
     * @var \ShopwareSdk\Model\TaxRules[]|null
     */
    public array|null $taxRules;
    public float|null $positionPrice;
    public string|null $taxStatus;
    public float|null $rawTotal;
}
