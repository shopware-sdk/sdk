<?php

namespace ShopwareSdk;

use Symfony\Component\HttpClient\Exception\ServerException;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;

abstract class AbstractApi implements ApiInterface
{
    public const API_URL = 'apiUrl';
    public const CLIENT_ID = 'client_id';
    public const CLIENT_SECRET = 'client_secret';
    public const AUTH_HEADER_NAME = 'Authorization';

    /**
     * @var HttpClientInterface
     */
    private $httpClient;

    /**
     * @var array<string, string>
     */
    private $config;

    private string $accessToken = '';
    private int $expiresAtTimestamp = 0;

    /**
     * AbstractAdminApi constructor.
     *
     * @param array<string, string> $config
     *
     * @param HttpClientInterface $httpClient
     *
     * @example [
     *     'apiUrl' => 'http://my.shopware.com',
     *     'client_id' => 'SWIAxxxxxxxxxxxxxxxxxxZVTG',
     *     'client_secret' => 'eWd3Qnc1R0U3ZmFjUDxxxxxxxxxxxxxxxxJCT3JzS3hvUHNyN0w'
     * ]
     */
    public function __construct($config = [], HttpClientInterface $httpClient = null)
    {
        $this->validateConfig($config);

        $this->config = $config;
        $this->httpClient = $httpClient ?: HttpClient::create();
    }

    public function request(string $method, string $relativePath, array|null $body = null, array $headers = []): ResponseInterface
    {
        $url = $this->config[self::API_URL] . $relativePath;

        return $this->httpClient->request($method, $url, [
            'headers' => array_merge($this->getHeaders(), $headers),
            'json' => $body,
        ]);
    }

    private function getHeaders() : array
    {
        $headers[self::AUTH_HEADER_NAME] = 'Bearer ' . $this->getAuthorizationToken();
        $headers['Content-Type'] = 'application/json';

        return $headers;
    }

    /**
     * @param array<string, string> $config
     *
     * @throws \InvalidArgumentException
     */
    private function validateConfig(array $config): void
    {
        $check = [self::CLIENT_ID, self::CLIENT_SECRET, self::API_URL];
        foreach ($check as $value) {
            if (empty($config[$value])) {
                $message = sprintf('%s cannot be empty', $value);

                throw new \InvalidArgumentException($message);
            }
        }
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
                ->request('POST', $this->config[self::API_URL] .'/api/oauth/token', [
                    'json' => [
                        'grant_type' => 'client_credentials',
                        'client_id' => $this->config[self::CLIENT_ID],
                        'client_secret' => $this->config[self::CLIENT_SECRET],
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
