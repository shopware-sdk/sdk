<?php declare(strict_types=1);

namespace ShopwareSdk\Tests\Unit;

use PHPUnit\Framework\TestCase;
use ShopwareSdk\AbstractApi;
use ShopwareSdk\Tests\ApiHelper;
use ShopwareSdk\Tests\MockResponse;
use Symfony\Component\HttpClient\Response\ResponseStream;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;
use Symfony\Contracts\HttpClient\ResponseStreamInterface;

final class AbstractApiTest extends TestCase
{
    public function testMergeHeader(): void
    {
        $spyHttpClient = new class implements HttpClientInterface {
            public array $options;

            public function request(string $method, string $url, array $options = []): ResponseInterface
            {
                $this->options = $options;
                $data = [];
                if(str_contains($url, '/api/oauth/token')) {
                    $data = [
                        'access_token' => 'unit-test-bearer',
                        'expires_in' => 3600
                    ];
                }
                return new MockResponse($data);
            }

            public function stream(iterable|ResponseInterface $responses, float $timeout = null): ResponseStreamInterface
            {
                return new ResponseStream(new \Generator());
            }

            public function withOptions(array $options): static
            {
                return $this;
            }
        };

        $abstractService = new class(ApiHelper::getConfig(), $spyHttpClient) extends AbstractApi {
        };

        $abstractService->request('GET', '/test',null, ['X-Test' => 'test', 'foo' => ['bar', 'baz']]);

        self::assertArrayHasKey('headers', $spyHttpClient->options);

        self::assertArrayHasKey('X-Test', $spyHttpClient->options['headers']);
        self::assertSame('test', $spyHttpClient->options['headers']['X-Test']);

        self::assertArrayHasKey('foo', $spyHttpClient->options['headers']);
        self::assertSame(['bar', 'baz'], $spyHttpClient->options['headers']['foo']);

        self::assertArrayHasKey('Authorization', $spyHttpClient->options['headers']);
        self::assertSame('Bearer unit-test-bearer', $spyHttpClient->options['headers']['Authorization']);

        self::assertArrayHasKey('Content-Type', $spyHttpClient->options['headers']);
        self::assertSame('application/json', $spyHttpClient->options['headers']['Content-Type']);
    }
}
