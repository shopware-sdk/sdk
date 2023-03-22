<?php declare(strict_types=1);

namespace ShopwareSdk\Service;

use ShopwareSdk\AbstractApi;
use ShopwareSdk\HydrateData;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

abstract class AbstractService
{
    private Serializer $serializer;
    private HydrateData $hydrate;

    public function __construct(
        private AbstractApi $client)
    {
        $encoders = [new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];

        $this->serializer = new Serializer($normalizers, $encoders);
        $this->hydrate = new HydrateData();
    }

    protected function request($method, $relativeUrl, $modelClass = null, $body = null, $options = [])
    {
        if ($body !== null) {
            $body = [
                'json' => json_decode($this->serializer->serialize($body, 'json'), true),
            ];
        }

        $response = $this->client->request($method, $relativeUrl, $body);
        $statusCode = $response->getStatusCode();

        $responseContent = $response->toArray(false);
        if ($statusCode < 200 || $statusCode >= 300) {
            throw new \Exception(json_encode($responseContent['errors'], JSON_PRETTY_PRINT), $statusCode);
        }

        return $this->hydrate->map($responseContent['data'], $modelClass);
    }
}
