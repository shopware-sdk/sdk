<?php

namespace ShopwareSdk\Service;


use ShopwareSdk\AbstractApi;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

abstract class AbstractService
{
    private Serializer $serializer;

    public function __construct(
        private AbstractApi $client)
    {
        $encoders = [new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];

        $this->serializer = new Serializer($normalizers, $encoders);
    }

    protected function request($method, $relativeUrl, $modelClass = null, $body = null)
    {

        if ($body !== null) {
            $body = [
                'json' => json_decode($this->serializer->serialize($body, 'json'), true),
            ];
            $body['json']['id'] = md5('test');
        }

        $response = $this->client->request($method, $relativeUrl, $body);
        $statusCode = $response->getStatusCode();

        $responseContent = $response->toArray(false);
        // Catching all NON 2xx status codes for further error processing
        if ($statusCode < 200 || $statusCode >= 300) {
            throw new \Exception(json_encode($responseContent['errors'], JSON_PRETTY_PRINT), $statusCode);
        }

//            if ($responseBody && $modelClass && class_exists($modelClass)) {
//                $responseJson = json_decode($responseBody, true);
//
//                //return new $modelClass($responseJson);
//            }
//
//            return json_decode($responseBody, true);
    }
}
