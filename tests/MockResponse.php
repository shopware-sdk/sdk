<?php declare(strict_types=1);

namespace ShopwareSdk\Tests;

use Symfony\Contracts\HttpClient\ResponseInterface;

final class MockResponse implements ResponseInterface
{
    public function __construct(
        private array $data,
    )
    {
    }

    public function getStatusCode(): int
    {
        return 200;
    }

    public function getHeaders(bool $throw = true): array
    {
        return [];
    }

    public function getContent(bool $throw = true): string
    {
        return json_encode($this->data);
    }

    public function toArray(bool $throw = true): array
    {
        return $this->data;
    }

    public function cancel(): void
    {

    }

    public function getInfo(string $type = null): mixed
    {
        return '';
    }

}
