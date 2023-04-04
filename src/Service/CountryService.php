<?php declare(strict_types=1);

namespace ShopwareSdk\Service;

use ShopwareSdk\Model\Country;
use ShopwareSdk\Model\CountryCollection;

class CountryService extends AbstractService
{
    protected const URL = '/api/country/';

    public function get(string $id): Country
    {
        return $this->request('GET', self::URL . $id, Country::class);
    }

    public function getAll(): CountryCollection
    {
        return $this->request('GET', self::URL, CountryCollection::class);
    }
}
