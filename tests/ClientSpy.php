<?php declare(strict_types=1);

namespace ShopwareSdk\Tests;

use Symfony\Component\HttpClient\Response\ResponseStream;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;
use Symfony\Contracts\HttpClient\ResponseStreamInterface;

final class ClientSpy implements HttpClientInterface
{
    public array $returnedResponse;

    public function __construct(array $mockData)
    {
        $url = ApiHelper::getConfig()->apiUrl;
        $this->returnedResponse[$url . '/api/oauth/token'] = new MockResponse([
            'access_token' => 'test',
            'expires_in' => 3600,
        ]);

        foreach ($mockData as $key => $data) {
            $this->returnedResponse[$url . $key] = new MockResponse($data);
        }
    }

    public function request(string $method, string $url, array $options = []): ResponseInterface
    {
        if(!isset($this->returnedResponse[$url])) {
            throw new \Exception('No mock response for ' . $url);
        }

        return $this->returnedResponse[$url];
    }

    public function stream(iterable|ResponseInterface $responses, float $timeout = null): ResponseStreamInterface
    {
        return new ResponseStream(new \Generator());
    }

    public function withOptions(array $options): static
    {
        return $this;
    }

}
