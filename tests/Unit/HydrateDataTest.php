<?php declare(strict_types=1);

namespace ShopwareSdk\Tests\Unit;

use PHPUnit\Framework\TestCase;
use ShopwareSdk\HydrateData;
use ShopwareSdk\Model\CurrencyCollection;
use ShopwareSdk\Model\ItemRounding;
use ShopwareSdk\Model\Order\Order;
use ShopwareSdk\Model\Order\OrderCollection;
use ShopwareSdk\Model\ShippingCosts;
use ShopwareSdk\Model\Tax;
use ShopwareSdk\Model\TaxCollection;
use ShopwareSdk\Model\TotalRounding;

final class HydrateDataTest extends TestCase
{
    private HydrateData $hydrateData;

    protected function setUp(): void
    {
        parent::setUp();

        $this->hydrateData = new HydrateData();
    }

    public function testMapCollection()
    {
        $taxCollection = $this->hydrateData->map($this->getTaxData(), TaxCollection::class);

        self::assertCount(3, $taxCollection->entities);

        self::assertInstanceOf(Tax::class, $taxCollection->entities[0]);
        self::assertSame('5c025a831a584fc0add209b81517e69d', $taxCollection->entities[0]->id);
        self::assertSame(19.0, $taxCollection->entities[0]->taxRate);
        self::assertSame('Standard rate', $taxCollection->entities[0]->name);
        self::assertSame(1, $taxCollection->entities[0]->position);

        self::assertInstanceOf(Tax::class, $taxCollection->entities[1]);
        self::assertSame('7fdbc3f0c0664c6bb8d96bd5c93dfd40', $taxCollection->entities[1]->id);
        self::assertSame(7.0, $taxCollection->entities[1]->taxRate);
        self::assertSame('Reduced rate', $taxCollection->entities[1]->name);
        self::assertSame(2, $taxCollection->entities[1]->position);

        self::assertInstanceOf(Tax::class, $taxCollection->entities[2]);
        self::assertSame('beacebf5ce694b79b0df78224beb26c0', $taxCollection->entities[2]->id);
        self::assertSame(0.0, $taxCollection->entities[2]->taxRate);
        self::assertSame('Reduced rate 2', $taxCollection->entities[2]->name);
        self::assertSame(3, $taxCollection->entities[2]->position);
    }

    public function testHydrataOrderObject()
    {
        $orderCollection = $this->hydrateData->map($this->getSmallOrderData(), OrderCollection::class);

        self::assertCount(1, $orderCollection->entities);

        $order = $orderCollection->entities[0];
        self::assertInstanceOf(Order::class, $order);
        self::assertSame('5785d7d3c8b041bcaa59899abd39c1b4', $order->id);
        self::assertSame('10001', $order->orderNumber);

        $shippingCosts = $order->shippingCosts;
        self::assertInstanceOf(ShippingCosts::class, $shippingCosts);
        self::assertSame(0.0, $shippingCosts->totalPrice);
        self::assertSame(0.0, $shippingCosts->unitPrice);
        self::assertSame(1.0, $shippingCosts->quantity);
        self::assertSame(0.0, $shippingCosts->calculatedTaxes[0]->tax);
        self::assertSame(0.0, $shippingCosts->calculatedTaxes[0]->price);
        self::assertSame(19.0, $shippingCosts->calculatedTaxes[0]->taxRate);

        self::assertSame(19.0, $shippingCosts->taxRules[0]->taxRate);
        self::assertSame(100.0, $shippingCosts->taxRules[0]->percentage);
    }

    public function testCurrencyData()
    {
        $currencyCollection = $this->hydrateData->map($this->getCurrencyData(), CurrencyCollection::class);

        self::assertCount(1, $currencyCollection->entities);

        self::assertSame('b7d2554b0ce847cd82f3ac9bd1c0dfca', $currencyCollection->entities[0]->id);
        self::assertSame(1.0, $currencyCollection->entities[0]->factor);
        self::assertSame('€', $currencyCollection->entities[0]->symbol);

        self::assertInstanceOf(ItemRounding::class, $currencyCollection->entities[0]->itemRounding);
        self::assertSame(2, $currencyCollection->entities[0]->itemRounding->decimals);
        self::assertSame(0.01, $currencyCollection->entities[0]->itemRounding->interval);
        self::assertTrue($currencyCollection->entities[0]->itemRounding->roundForNet);

        self::assertInstanceOf(TotalRounding::class, $currencyCollection->entities[0]->totalRounding);
        self::assertSame(2, $currencyCollection->entities[0]->totalRounding->decimals);
        self::assertSame(0.01, $currencyCollection->entities[0]->totalRounding->interval);
        self::assertTrue($currencyCollection->entities[0]->totalRounding->roundForNet);
    }

    public function getCurrencyData(): array
    {
        return
            [
                [
                    'id' => 'b7d2554b0ce847cd82f3ac9bd1c0dfca',
                    'type' => 'currency',
                    'attributes' =>
                        [
                            'factor' => 1.0,
                            'symbol' => '€',
                            'isoCode' => 'EUR',
                            'shortName' => 'EUR',
                            'name' => 'Euro',
                            'position' => 1,
                            'isSystemDefault' => true,
                            'customFields' => NULL,
                            'itemRounding' =>
                                [
                                    'extensions' =>
                                        [
                                        ],
                                    'decimals' => 2,
                                    'interval' => 0.01,
                                    'roundForNet' => true,
                                ],
                            'totalRounding' =>
                                [
                                    'extensions' =>
                                        [
                                        ],
                                    'decimals' => 2,
                                    'interval' => 0.01,
                                    'roundForNet' => true,
                                ],
                            'taxFreeFrom' => 0.0,
                        ],

                ],
            ];
    }

    public function getTaxData(): array
    {
        return [
            [
                'id' => '5c025a831a584fc0add209b81517e69d',
                'type' => 'tax',
                'attributes' =>
                    [
                        'taxRate' => 19.0,
                        'name' => 'Standard rate',
                        'position' => 1,
                        'customFields' => NULL,
                    ],
            ],
            [
                'id' => '7fdbc3f0c0664c6bb8d96bd5c93dfd40',
                'type' => 'tax',
                'attributes' =>
                    [
                        'taxRate' => 7.0,
                        'name' => 'Reduced rate',
                        'position' => 2,
                        'customFields' => NULL,
                    ],
            ],
            [
                'id' => 'beacebf5ce694b79b0df78224beb26c0',
                'type' => 'tax',
                'attributes' =>
                    [
                        'taxRate' => 0.0,
                        'name' => 'Reduced rate 2',
                        'position' => 3,
                        'customFields' => NULL,
                    ],
            ],
        ];
    }

    public function getSmallOrderData()
    {
        return
            [
                0 =>
                    [
                        'id' => '5785d7d3c8b041bcaa59899abd39c1b4',
                        'type' => 'order',
                        'attributes' =>
                            [
                                'orderNumber' => '10001',
                                'shippingCosts' =>
                                    [
                                        'unitPrice' => 0.0,
                                        'quantity' => 1,
                                        'totalPrice' => 0.0,
                                        'calculatedTaxes' =>
                                            [
                                                0 =>
                                                    [
                                                        'extensions' =>
                                                            [
                                                            ],
                                                        'tax' => 0.0,
                                                        'taxRate' => 19.0,
                                                        'price' => 0.0,
                                                    ],
                                            ],
                                        'taxRules' =>
                                        [
                                            [

                                                'taxRate' => 19.0,
                                                'percentage' => 100.0,

                                            ]
                                        ],
                                        'referencePrice' => NULL,
                                        'listPrice' => NULL,
                                        'regulationPrice' => NULL,
                                    ],
                            ],
                    ],
            ];
    }
}
