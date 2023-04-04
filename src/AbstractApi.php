<?php declare(strict_types=1);

namespace ShopwareSdk;

use Symfony\Component\HttpClient\Exception\ServerException;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;

abstract class AbstractApi implements ApiInterface
{
    public const AUTH_HEADER_NAME = 'Authorization';

    private HttpClientInterface $httpClient;

    private string $accessToken = '';
    private int $expiresAtTimestamp = 0;

    /**
     * @example [
     *   new Config(
     *     apiUrl: 'http://my.shopware.com',
     *     clientId: 'SWIAxxxxxxxxxxxxxxxxxxZVTG',
     *     clientSecret: 'eWd3Qnc1R0U3ZmFjUDxxxxxxxxxxxxxxxxJCT3JzS3hvUHNyN0w'
     *   );
     */
    public function __construct(
        public readonly Config $config,
        HttpClientInterface $httpClient = null
    )
    {
        $this->httpClient = $httpClient ?: HttpClient::create();
    }

    public function request(string $method, string $relativePath, array|null $body = null, array $headers = []): ResponseInterface
    {
        $url = $this->config->apiUrl . $relativePath;

        return $this->httpClient->request($method, $url, [
            'headers' => array_merge($this->getHeaders(), $headers),
            'json' => $body,
        ]);
    }

    private function getHeaders() : array
    {
        $headers[self::AUTH_HEADER_NAME] = 'Bearer ' . $this->getAuthorizationToken();
        $headers['Content-Type'] = 'application/json';
        $headers['Accept'] = 'application/json';

        return $headers;
    }

    private function getAuthorizationToken(): string
    {
        if ($this->invalidAccessToken()) {
            $this->setAccessToken();
        }

        return $this->accessToken;
    }


    /**
     * @return bool
     */
    private function invalidAccessToken(): bool
    {
        if (!isset($this->accessToken)) {
            return true;
        }

        if ($this->expiresAtTimestamp <= (new \DateTime())->getTimestamp()) {
            return true;
        }

        return false;
    }

    /**
     * @return void
     * @throws \Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface
     */
    private function setAccessToken(): void
    {
        $requestTimeStamp = (new \DateTime())->getTimestamp();

        try {
            $response = $this->httpClient
                ->request('POST', $this->config->apiUrl .'/api/oauth/token', [
                    'json' => [
                        'grant_type' => 'client_credentials',
                        'client_id' => $this->config->clientId,
                        'client_secret' => $this->config->clientSecret,
                        'scopes' => null,
                    ],
                ]);

            /** @var object $data */
            $data = $response->toArray();
        } catch (ServerException $e) {
            throw new \OAuthException($e->getMessage());
        }

        $this->accessToken = (string) $data['access_token'];
        $this->expiresAtTimestamp = $requestTimeStamp + (int) $data['expires_in'];
    }
}
