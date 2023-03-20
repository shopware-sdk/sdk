<?php declare(strict_types=1);

namespace ShopwareSdk\Model;

class CurrencyCollection implements CollectionInterface
{
    /**
     * @var \ShopwareSdk\Model\Currency[]
     */
    public array $entities = [];

    public function getClassMap()
    {
        return Currency::class;
    }
}
