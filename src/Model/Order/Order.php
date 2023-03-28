<?php declare(strict_types=1);

namespace ShopwareSdk\Model\Order;

use ShopwareSdk\Model\ItemRounding;
use ShopwareSdk\Model\Order\Price;
use ShopwareSdk\Model\ShippingCosts;
use ShopwareSdk\Model\TotalRounding;

class Order
{
    public string|null $id;
    public string|null $versionId;
    public int|null $autoIncrement;
    public ShippingCosts|null $shippingCosts;
    public string|null $orderNumber;
    public string|null $billingAddressId;
    public string|null $billingAddressVersionId;
    public string|null $currencyId;
    public string|null $languageId;
    public string|null $salesChannelId;
    public string|null $orderDateTime;
    public string|null $orderDate;
    public Price|null $price;

    public float|null $amountTotal;
    public float|null $amountNet;
    public float|null $positionPrice;
    public string|null $taxStatus;
    public ItemRounding|null $itemRounding;
    public TotalRounding|null $totalRounding;
    public string|null $createdAt;
    public string|null $updatedAt;

}
