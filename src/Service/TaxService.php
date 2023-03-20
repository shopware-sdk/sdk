<?php declare(strict_types=1);

namespace ShopwareSdk\Service;

use ShopwareSdk\Model\TaxCollection;

class TaxService extends AbstractService
{
    private const URL = '/api/tax/';
    public function getAll(): TaxCollection
    {
        return $this->request('GET', self::URL, TaxCollection::class);
    }
}
