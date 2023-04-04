<?php

namespace ShopwareSdk\Service;

use ShopwareSdk\AbstractApi;
use ShopwareSdk\Model\Country;

class ServiceFactory
{
    /**
     * @var array<string, string>
     */
    protected $classMap = [
        'country' => CountryService::class,
        'currency' => CurrencyService::class,
        'product' => ProductService::class,
        'tax' => TaxService::class,
    ];

    /**
     * @var array<string, AbstractService>
     */
    private $services = [];

    public function __construct(
        private readonly AbstractApi $client
    )
    {
    }

    public function get(string $name)
    {
        if (!\array_key_exists($name, $this->services)) {
            $this->services[$name] = new $this->classMap[$name]($this->client);
        }

        return $this->services[$name];
    }
}
