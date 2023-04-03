<?php declare(strict_types=1);

namespace ShopwareSdk\Tests;

use ShopwareSdk\AdminApi;
use ShopwareSdk\Config;

final class ApiHelper
{
    public static function createAdminApi(): AdminApi
    {
        return new AdminApi(self::getConfig());
    }

    public static function getConfig(): Config
    {
        return new Config(
            $_ENV['API_URL'],
            $_ENV['CLIENT_ID'],
            $_ENV['CLIENT_SECRET'],
        );
    }
}
