<?php declare(strict_types=1);

namespace ShopwareSdk\Tests\Api;

use ShopwareSdk\AdminAPI;

final class ApiHelper
{
    public static function createAdminApi(): AdminAPI
    {
        $config = [
            'apiUrl' => $_ENV['API_URL'],
            'client_id' => $_ENV['CLIENT_ID'] ,
            'client_secret' => $_ENV['CLIENT_SECRET'],
        ];
        return new AdminAPI($config);
    }
}
