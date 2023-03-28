<?php declare(strict_types=1);

namespace ShopwareSdk\Tests;

use ShopwareSdk\AdminAPI;

final class ApiHelper
{
    public static function createAdminApi(): AdminAPI
    {
        return new AdminAPI(self::getConfig());
    }

    public static function getConfig(): array
    {
        return [
            'apiUrl' => $_ENV['API_URL'],
            'client_id' => $_ENV['CLIENT_ID'],
            'client_secret' => $_ENV['CLIENT_SECRET'],
        ];
    }
}
