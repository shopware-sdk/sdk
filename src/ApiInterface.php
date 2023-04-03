<?php declare(strict_types=1);

namespace ShopwareSdk;

use Symfony\Contracts\HttpClient\ResponseInterface;

interface ApiInterface
{
    public function request(string $method, string $relativePath, array|null $body = null, array $headers = []): ResponseInterface;
}
