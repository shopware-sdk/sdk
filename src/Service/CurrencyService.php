<?php declare(strict_types=1);

namespace ShopwareSdk\Service;

use ShopwareSdk\Model\Currency;
use ShopwareSdk\Model\CurrencyCollection;

class CurrencyService extends AbstractService
{
    protected const URL = '/api/currency/';

    public function getAll(array $option = []): CurrencyCollection
    {
        return $this->request('GET', self::URL, CurrencyCollection::class, null, $option);
    }
}
