<?php declare(strict_types=1);

namespace ShopwareSdk\Model;

class Country
{
    public string|null $id;
    public string|null $createdAt;
    public string|null $updatedAt;
    public string|null $name;
    public string|null $iso;
    public int|null $position;
    public bool|null $taxFree;
    public bool|null $active;
    public bool|null $shippingAvailable;
    public string|null $iso3;
    public bool|null $displayStateInRegistration;
    public bool|null $forceStateInRegistration;
    public bool|null $companyTaxFree;
    public bool|null $checkVatIdPattern;
    public bool|null $vatIdRequired;
    public bool|null $postalCodeRequired;
    public bool|null $checkPostalCodePattern;
    public bool|null $checkAdvancedPostalCodePattern;
    public CustomerTax|null $customerTax;
    public CompanyTax|null $companyTax;
    public array|null $addressFormat;
    public string|null $defaultPostalCodePattern;
}

