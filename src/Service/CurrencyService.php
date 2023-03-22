<?php declare(strict_types=1);

namespace ShopwareSdk\Service;

use ShopwareSdk\Model\Currency;
use ShopwareSdk\Model\CurrencyCollection;

class CurrencyService extends AbstractService
{
    private const URL = '/api/currency/';
    public function getCurrencieByIsoCode(string $currencyName): Currency
    {
        return $this->request('GET', self::URL, Currency::class);
    }

    public function getAll(): CurrencyCollection
    {
        return $this->request('GET', self::URL, CurrencyCollection::class);
    }
}
