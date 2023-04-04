<?php declare(strict_types=1);

namespace ShopwareSdk\Tests\Unit\Service;

use PHPUnit\Framework\TestCase;
use ShopwareSdk\AdminApi;
use ShopwareSdk\Tests\ApiHelper;
use ShopwareSdk\Tests\ClientSpy;

final class CountryServiceTest extends TestCase
{
    public function testGetId(): void
    {
        $clientSpy = new ClientSpy([
            '/api/country/55dd89c0e4ca4a36b8f63c68c45851bb' => json_decode(file_get_contents(__DIR__ . '/json/country.json'), true)
        ]);
        $adminApi = new AdminApi(ApiHelper::getConfig(), $clientSpy);
        $country = $adminApi->country->get('55dd89c0e4ca4a36b8f63c68c45851bb');

        self::assertSame('55dd89c0e4ca4a36b8f63c68c45851bb', $country->id);
        self::assertSame('2023-03-01T20:36:05.788+00:00', $country->createdAt);
        self::assertSame('Morocco', $country->name);
        self::assertSame('MA', $country->iso);
        self::assertSame(10, $country->position);
        self::assertSame('2023-04-01T10:10:07.051+00:00', $country->updatedAt);
        self::assertSame(true, $country->active);
        self::assertSame(true, $country->shippingAvailable);
        self::assertSame('MAR', $country->iso3);
        self::assertSame(false, $country->taxFree);
        self::assertSame(false, $country->displayStateInRegistration);
        self::assertSame(false, $country->forceStateInRegistration);
        self::assertSame(false, $country->companyTaxFree);
        self::assertSame(false, $country->checkVatIdPattern);
        self::assertSame(false, $country->vatIdRequired);
        self::assertSame(false, $country->postalCodeRequired);
        self::assertSame(false, $country->checkPostalCodePattern);
        self::assertSame(false, $country->checkAdvancedPostalCodePattern);
        self::assertSame('b7d2554b0ce847cd82f3ac9bd1c0dfca', $country->customerTax->currencyId);
        self::assertSame(0, $country->customerTax->amount);
        self::assertSame(false, $country->customerTax->enabled);
        self::assertSame('b7d2554b0ce847cd82f3ac9bd1c0dfca', $country->companyTax->currencyId);
        self::assertSame(0, $country->companyTax->amount);
        self::assertSame(false, $country->companyTax->enabled);

        self::assertCount(5, $country->addressFormat);
        self::assertCount(3, $country->addressFormat[0]);
        self::assertSame('address/company', $country->addressFormat[0][0]);
        self::assertSame('symbol/dash', $country->addressFormat[0][1]);

        self::assertCount(2, $country->addressFormat[3]);
        self::assertSame('address/zipcode', $country->addressFormat[3][0]);
        self::assertSame('address/city', $country->addressFormat[3][1]);

        self::assertSame('\d{5}', $country->defaultPostalCodePattern);
    }

    public function testGetAll(): void
    {
        $clientSpy = new ClientSpy([
            '/api/country/' => json_decode(file_get_contents(__DIR__ . '/json/country_all.json'), true)
        ]);
        $adminApi = new AdminApi(ApiHelper::getConfig(), $clientSpy);
        $countries = $adminApi->country->getAll();

        self::assertCount(2, $countries->entities);

        self::assertSame('00ed566ac48c4bb588438b6ab5ff4b84', $countries->entities[0]->id);
        self::assertSame('Nepal', $countries->entities[0]->name);
        self::assertSame('NP', $countries->entities[0]->iso);
        self::assertSame('b7d2554b0ce847cd82f3ac9bd1c0dfca', $countries->entities[0]->customerTax->currencyId);
        self::assertCount(5, $countries->entities[0]->addressFormat);
        self::assertCount(3, $countries->entities[0]->addressFormat[0]);
        self::assertSame('symbol/dash', $countries->entities[0]->addressFormat[0][1]);

        self::assertSame('0130972174254197a49a35006e769f82', $countries->entities[1]->id);
        self::assertSame('Cuba', $countries->entities[1]->name);
        self::assertSame('CU', $countries->entities[1]->iso);
    }

}
