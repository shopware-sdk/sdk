<?php

namespace ShopwareSdk\Service;

use ShopwareSdk\AbstractApi;

/**
 * Factory to create API services.
 */
class ServiceFactory
{
    /**
     * @var array<string, string>
     */
    protected $classMap = [
        'product' => ProductService::class,
    ];

    /**
     * @var array<string, AbstractService>
     */
    private $services = [];

    public function __construct(
        private AbstractApi $client)
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
