<?php declare(strict_types=1);

namespace ShopwareSdk\Tests\Unit\Service;

use PHPUnit\Framework\TestCase;
use ShopwareSdk\ApiInterface;
use ShopwareSdk\Service\AbstractService;
use ShopwareSdk\Tests\MockResponse;
use Symfony\Contracts\HttpClient\ResponseInterface;

final class AbstractServiceTest extends TestCase
{
    public function testRequestQuery()
    {
        $spyApi = $this->getSpyApi();
        $abstractService = new class($spyApi) extends AbstractService {
            public function request($method, $relativeUrl, $modelClass = null, $body = null, array $query = [],array $options = [])
            {
                return parent::request($method, $relativeUrl, $modelClass, $body, $query,$options);
            }
        };

        $response = $abstractService->request(
            'GET',
            '/test',
            null,
            ['john' => ['doe', 'work' => ['cologne', 'dev']]], ['foo' => 'bar', 'unit' => ['test', 'yeah']],
            ['X-Test' => 'test']
        );

        self::assertSame('GET', $spyApi->method);
        self::assertSame('/test?foo=bar&unit%5B0%5D=test&unit%5B1%5D=yeah', $spyApi->relativePath);
        self::assertSame(['john' => ['doe', 'work' => ['cologne', 'dev']]], $spyApi->body);
        self::assertSame(['X-Test' => 'test'], $spyApi->header);
        self::assertNull($response);
    }

    /**
     * @return \ShopwareSdk\ApiInterface
     */
    private function getSpyApi()
    {
        $spyApi = new class implements ApiInterface {
            public string $method;
            public string $relativePath;
            public ?array $body = null;
            public array $header = [];

            public function request(string $method, string $relativePath, ?array $body = null, array $header = []): ResponseInterface
            {
                $this->method = $method;
                $this->relativePath = $relativePath;
                $this->body = $body;
                $this->header = $header;

                return new MockResponse([]);
            }
        };
        return $spyApi;
    }
}
