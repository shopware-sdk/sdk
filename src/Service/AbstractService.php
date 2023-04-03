<?php declare(strict_types=1);

namespace ShopwareSdk\Service;

use ShopwareSdk\ApiInterface;
use ShopwareSdk\HydrateData;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

abstract class AbstractService
{
    private Serializer $serializer;
    private HydrateData $hydrate;

    public function __construct(
        private ApiInterface $client)
    {
        $encoders = [new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];

        $this->serializer = new Serializer($normalizers, $encoders);
        $this->hydrate = new HydrateData();
    }

    protected function request($method, $relativeUrl, $modelClass = null, $body = null, $options = [])
    {
        if ($body !== null) {
            $body = json_decode($this->serializer->serialize($body, 'json'), true);
        }

        $response = $this->client->request($method, $relativeUrl, $body);
        $statusCode = $response->getStatusCode();


        if ($statusCode < 200 || $statusCode >= 300) {
            $responseContent = $response->toArray(false);
            throw new \Exception(json_encode($responseContent['errors'], JSON_PRETTY_PRINT), $statusCode);
        }

        if($modelClass === null) {
            return;
        }

        $responseContent = $response->toArray(false);
        return $this->hydrate->map($responseContent['data'], $modelClass);
    }
}
