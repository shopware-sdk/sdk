<?php declare(strict_types=1);

namespace ShopwareSdk\Model;

class ShippingCosts
{
    public float|null $unitPrice;
    public float|null $quantity;
    public float|null $totalPrice;

    /**
     * @var \ShopwareSdk\Model\CalculatedTaxes[]|null
     */
    public array|null $calculatedTaxes;

    /**
     * @var \ShopwareSdk\Model\TaxRules[]|null
     */
    public array|null $taxRules;
}
