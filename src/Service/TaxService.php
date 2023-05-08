<?php declare(strict_types=1);

namespace ShopwareSdk\Service;

use ShopwareSdk\Model\TaxCollection;

class TaxService extends AbstractService
{
    protected const URL = '/api/tax/';
    public function getAll(array $option = []): TaxCollection
    {
        return $this->request('GET', self::URL, TaxCollection::class, null, $option);
    }
}
