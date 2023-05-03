<?php declare(strict_types=1);

namespace ShopwareSdk\Tests\Api\Model;

use PHPUnit\Framework\TestCase;
use ShopwareSdk\Model\Currency;
use ShopwareSdk\Tests\ApiHelper;

class CurrencyTest extends TestCase
{
    public function testGetAll()
    {
        $currencyCollection = ApiHelper::createAdminApi()->currency->getAll();
        self::assertCount(9, $currencyCollection->entities);

        $currency = $this->getCurrenyByIsoCode('EUR', $currencyCollection->entities);
        self::assertSame('EUR', $currency->isoCode);
        self::assertSame('Euro', $currency->name);
        self::assertSame('€', $currency->symbol);
        self::assertSame(1.0, $currency->factor);

        $itemRounding = $currency->itemRounding;
        self::assertSame(0.01, $itemRounding->interval);
        self::assertSame(2, $itemRounding->decimals);
        self::assertSame(true, $itemRounding->roundForNet);

        $totalRounding = $currency->totalRounding;
        self::assertSame(0.01, $totalRounding->interval);
        self::assertSame(2, $totalRounding->decimals);
        self::assertSame(true, $totalRounding->roundForNet);
    }

    public function testGetCurrencyByName()
    {
        $query = [
            'filter' =>
                [
                    'isoCode' => 'EUR',
                ],
        ];

        $currencyCollection = ApiHelper::createAdminApi()->currency->getAll($query);
        self::assertCount(1, $currencyCollection->entities);

        $currency = $currencyCollection->entities[0];
        self::assertSame('EUR', $currency->isoCode);
        self::assertSame('Euro', $currency->name);
        self::assertSame('€', $currency->symbol);
        self::assertSame(1.0, $currency->factor);
    }

    /**
     * @param string $isoCode
     * @param \ShopwareSdk\Model\Currency[] $enities
     *
     * @throws \Exception
     * @return \ShopwareSdk\Model\Currency
     */
    private function getCurrenyByIsoCode(string $isoCode, array $enities): Currency
    {
        foreach ($enities as $currency) {
            if ($currency->isoCode === $isoCode) {
                return $currency;
            }
        }
        throw new \Exception('Currency not found');
    }
}
