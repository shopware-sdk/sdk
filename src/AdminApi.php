<?php declare(strict_types=1);

namespace ShopwareSdk;

use ShopwareSdk\Service\ServiceFactory;

/**
 * @property \ShopwareSdk\Service\CountryService $country
 * @property \ShopwareSdk\Service\CurrencyService $currency
 * @property \ShopwareSdk\Service\ProductService $product
 * @property \ShopwareSdk\Service\TaxService $tax
 */
class AdminApi extends AbstractApi
{
    private ServiceFactory|null $serviceFactory = null;

    public function __get($name)
    {
        if ($this->serviceFactory === null ) {
            $this->serviceFactory = new ServiceFactory($this);
        }

        return $this->serviceFactory->get($name);
    }
}
