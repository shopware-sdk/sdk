# Shopware SDK

[![codecov](https://codecov.io/gh/shopware-sdk/sdk/branch/main/graph/badge.svg)](https://codecov.io/gh/shopware-sdk/sdk)

Sponsor by <a href="https://www.valantic.com/cx"><img src="https://www.valantic.com/wp-content/themes/valantic/img/logo-valantic.svg" style="margin:0 0 0 0" width="60px"/></a>

---

> Shopware SDK is currently being developed



Elevate your integration with the Shopware API through the swifter SDK API, designed specifically for seamless connectivity with external systems.

🔄 Time to evolve! Abandon the use of arrays and embrace the power of objects. 🔄

🛠️ The Shopware SDK is your go-to tool for this transformation. 🛠️

🔍 Can't find all the API endpoints? No worries! If you spot any omissions, kindly create an issue or submit a PR. 

Your contributions are always welcome! 🤗

## How to use

### Composer

> As the Shopware SDK is currently under development, we have not yet assigned a version. Once it's completed, we will create a version on Packagist.

Add this code in your composer.json
```bash
"require": {
    ...
    "shopware-sdk/sdk": "dev-main"
}
```

### Initialize the SDK

```php
$config = new \ShopwareSdk\Config(
    'http://my.shopware.com',
    'SWIAxxxxxxxxxxxxxxxxxxZVTG',
    'eWd3Qnc1R0U3ZmFjUDxxxxxxxxxxxxxxxxJCT3JzS3hvUHNyN0w',
);

$adminApi = new \ShopwareSdk\AdminApi($config);

$currencies = $adminApi->currency->getAll();
var_dump($currencies);
```

Output:
```bash
array(2) {
  [0]=>
  object(ShopwareSdk\Model\Currency)#3 (5) {
    ["id"]=>
    string(36) "c6d8c3f0-8b1e-4b0e-9b2e-8c3f0b1e4b0e"
    ["name"]=>
    string(3) "USD"
    ["isoCode"]=>
    string(3) "USD"
    ["symbol"]=>
    string(1) "$"
    ["factor"]=>
    int(100)
  }
  [1]=>
  object(ShopwareSdk\Model\Currency)#4 (5) {
    ["id"]=>
    string(36) "c6d8c3f0-8b1e-4b0e-9b2e-8c3f0b1e4b0e"
    ["name"]=>
    string(3) "EUR"
    ["isoCode"]=>
    string(3) "EUR"
    ["symbol"]=>
    string(1) "€"
    ["factor"]=>
    int(100)
  }
}
``` 

## Extending the SDK

### Create a new service

It may be that a service is not there and you need it.
Then you can simply create it and register it for AdminApi.

#### Example:

We create a NewService and extend AbstractService to access the method request.

```php

namespace App\ShopwareSdk\Service;

use ShopwareSdk\Service\AbstractService;

class NewService extends AbstractService
{
    protected const URL = '/api/new_service/';
    
    public function getAll(): NewServiceCollection
    {
        return $this->request('GET', self::URL, NewServiceCollection::class);
    }
}
```

Now when we create the AdminApi we just have to say under which name the service can be accessed.

```php

use App\ShopwareSdk\Service\NewService;

$config = new Config(
    'https://shopware.test',
    'clientId',
    'clientSecret',
    [
        'newService' => NewService::class,
    ]
);

$adminApi = new AdminApi($config);
```

Now we can access the service through the AdminApi.

```php
/** @var NewService $newService */
$newService = $adminApi->newService;
$newService->getAll();
```

### Replace a default service

It could be that you want to extend or change the existing service.
E.g. you want to add new methods or maybe change the model class.

#### Example:

We create a ProductService and extend ProductService to add new method.

```php

namespace App\ShopwareSdk\Service;

use ShopwareSdk\Service\ProductService;

class MyProductService extends ProductService
{
    public function getNewFancyMethod(): NewServiceCollection
    {
        return $this->request('GET', self::URL, NewServiceCollection::class);
    }
}
```

Now we just have to tell our Config that the Product-Service is our ProductService.


```php

use App\ShopwareSdk\Service\MyProductService

$config = new Config(
    'https://shopware.test',
    'clientId',
    'clientSecret',
    [
        'product' => MyProductService::class,
    ]
);

$adminApi = new AdminApi($config);
```

Now we can reach the service via the AdminApi.

```php
/** @var MyProductService $newService */
$product = $adminApi->product;
$product->getNewFancyMethod();
```

## Work locally

Start shopware-demo shopware instance and set client credentials

```bash
docker run --rm -p 8000:80 dockware/play

python3 .github/api_sw_client.py
```

_Python Library:_ `pip install requests`



