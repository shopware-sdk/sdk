<?php declare(strict_types=1);

namespace ShopwareSdk\Model;

class CountryCollection implements CollectionInterface
{
    /**
     * @var \ShopwareSdk\Model\Country[]
     */
    public array $entities = [];

    public function getClassMap()
    {
        return Country::class;
    }

}
