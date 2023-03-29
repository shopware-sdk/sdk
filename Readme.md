# Shopware SDK


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
    "shopware/sdk": "dev-main"
}
```

### Initialize the SDK


```php
$adminApi = new AdminApi([
    'apiUrl' => 'http://my.shopware.com',
    'client_id' => 'SWIAxxxxxxxxxxxxxxxxxxZVTG',
    'client_secret' => 'eWd3Qnc1R0U3ZmFjUDxxxxxxxxxxxxxxxxJCT3JzS3hvUHNyN0w',
]);

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


## Work locally

Start shopware-demo shopware instance and set client credentials

```bash
docker run --rm -p 8000:80 dockware/play

python3 .github/api_credentials.py
```

_Python Library:_ `pip install requests`



