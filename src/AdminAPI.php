<?php

namespace ShopwareSdk;


use ShopwareSdk\Service\ServiceFactory;

/**
 * Allows access to AdminApi functions.
 *
 * @property \ShopwareSdk\Service\ProductService $product
 * @property \ShopwareSdk\Service\TaxService $tax
 * @property \ShopwareSdk\Service\CurrencyService $currency
 * @property \ShopwareSdk\Service\OrderService $order
 */
class AdminAPI extends AbstractApi
{
    /**
     * @var \ShopwareSdk\Service\ServiceFactory
     */
    private $serviceFactory;

    public function __get($name)
    {
        if (null === $this->serviceFactory) {
            $this->serviceFactory = new ServiceFactory($this);
        }

        return $this->serviceFactory->get($name);
    }
}
