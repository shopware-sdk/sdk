<?php declare(strict_types=1);

namespace ShopwareSdk\Model;

class TaxCollection implements CollectionInterface
{
    /**
     * @var \ShopwareSdk\Model\Tax[]
     */
    public array $entities = [];

    public function getClassMap()
    {
        return Tax::class;
    }
}
