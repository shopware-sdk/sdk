<?php declare(strict_types=1);

namespace ShopwareSdk\Service;

use ShopwareSdk\Model\Currency;

class CurrencyService extends AbstractService
{
    private const URL = '/api/currency/';
    public function getCurrencieByIsoCode(string $currencyName)
    {
        return $this->request('GET', self::URL, Currency::class);
    }

    public function getAll()
    {
        return $this->request('GET', self::URL, Currency::class);
    }
}
