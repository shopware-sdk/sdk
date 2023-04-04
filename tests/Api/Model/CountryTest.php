<?php declare(strict_types=1);

namespace ShopwareSdk\Tests\Api\Model;

use PHPUnit\Framework\TestCase;
use ShopwareSdk\Model\Country;
use ShopwareSdk\Model\CustomerTax;
use ShopwareSdk\Service\CountryService;
use ShopwareSdk\Tests\ApiHelper;

class CountryTest extends TestCase
{
    private CountryService $country;

    protected function setUp(): void
    {
        parent::setUp();

        $this->country = ApiHelper::createAdminApi()->country;
    }

    public function testGetAll()
    {
        $countryCollection = $this->country->getAll();
        self::assertCount(250, $countryCollection->entities);

        $country = $this->getCountryByIso('PL', $countryCollection->entities);

        self::assertSame('Poland', $country->name);
        self::assertSame('POL', $country->iso3);

        $country = $this->getCountryByIso('DE', $countryCollection->entities);

        self::assertSame('Germany', $country->name);
        self::assertSame(true, $country->active);
        self::assertSame('DEU', $country->iso3);
        self::assertInstanceOf(CustomerTax::class, $country->customerTax);

        return $country->id;
    }

    /**
     * @depends testGetAll
     */
    public function testGetId(string $id)
    {
        $country = $this->country->get($id);

        self::assertSame('Germany', $country->name);
        self::assertSame(true, $country->active);
        self::assertSame('DEU', $country->iso3);
    }

    /**
     * @param string $isoCode
     * @param \ShopwareSdk\Model\Country[] $entities
     *
     * @throws \Exception
     * @return \ShopwareSdk\Model\Country
     */
    private function getCountryByIso(string $isoCode, array $entities): Country
    {
        foreach ($entities as $currency) {
            if ($currency->iso === $isoCode) {
                return $currency;
            }
        }

        throw new \Exception('Country not found');
    }
}
