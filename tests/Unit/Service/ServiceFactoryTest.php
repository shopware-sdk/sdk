<?php declare(strict_types=1);

namespace ShopwareSdk\Tests\Unit\Service;

use PHPUnit\Framework\TestCase;
use ShopwareSdk\AdminApi;
use ShopwareSdk\Config;
use ShopwareSdk\Service\CountryService;
use ShopwareSdk\Service\ProductService;
use ShopwareSdk\Service\ServiceFactory;
use Symfony\Contracts\HttpClient\HttpClientInterface;


final class ServiceFactoryTest extends TestCase
{
    public function testAddNewService()
    {
        $config = new Config(
            'https://shopware.test',
            'clientId',
            'clientSecret',
            [
                'newService' => CountryService::class,
            ]
        );
        $serviceFactory = $this->getServiceFactory($config);

        $countryService = $serviceFactory->get('newService');
        self::assertInstanceOf(CountryService::class, $countryService);
    }

    public function testService()
    {
        $config = new Config(
            'https://shopware.test',
            'clientId',
            'clientSecret',
        );
        $serviceFactory = $this->getServiceFactory($config);

        $productService = $serviceFactory->get('product');
        self::assertInstanceOf(ProductService::class, $productService);
    }

    public function testReplaceService()
    {
        $config = new Config(
            'https://shopware.test',
            'clientId',
            'clientSecret',
            [
                'product' => CountryService::class,
            ]
        );
        $serviceFactory = $this->getServiceFactory($config);

        $countryAsProductService = $serviceFactory->get('product');
        self::assertInstanceOf(CountryService::class, $countryAsProductService);
    }

    private function getServiceFactory(Config $config): ServiceFactory
    {
        $adminApi = new AdminApi($config, $this->createMock(HttpClientInterface::class));
        return new ServiceFactory($adminApi);
    }
}
