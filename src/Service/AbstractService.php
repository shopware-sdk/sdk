<?php

namespace ShopwareSdk\Service;


use ShopwareSdk\AbstractApi;

abstract class AbstractService
{
    public function __construct(
        private AbstractApi $client)
    {
    }

    protected function request($method, $relativeUrl, $modelClass = null, $body = null)
    {
        try {
//            if ($body instanceof ApiObject) {
//                $body = $body->toJson();
//            } elseif (null !== $body) {
//                $body = json_encode($body);
//            }

            $response = $this->client->request($method, $relativeUrl, $body);
            $statusCode = $response->getStatusCode();

            $responseContent = $response->toArray(false);
            // Catching all NON 2xx status codes for further error processing
            if ($statusCode < 200 || $statusCode >= 300) {
                ;
                $errorMsg = $responseContent['errors'][0]['detail'] ?? 'Error';
                throw new \Exception($errorMsg, $statusCode);
            }

//            if ($responseBody && $modelClass && class_exists($modelClass)) {
//                $responseJson = json_decode($responseBody, true);
//
//                //return new $modelClass($responseJson);
//            }
//
//            return json_decode($responseBody, true);
        } catch (ClientExceptionInterface $e) {
            throw $e;
        }
    }
}
