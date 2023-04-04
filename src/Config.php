<?php declare(strict_types=1);

namespace ShopwareSdk;

final class Config
{
    public function __construct(
        public readonly string $apiUrl,
        public readonly string $clientId,
        public readonly string $clientSecret,
        public readonly array  $classMaps = [],
    )
    {
    }
}
