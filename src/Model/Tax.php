<?php declare(strict_types=1);

namespace ShopwareSdk\Model;

class Tax
{
    public string|null $id;
    public string|null $name;
    public float|null $taxRate;
    public int|null $position;
}
