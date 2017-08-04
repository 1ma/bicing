<?php

declare(strict_types=1);

namespace UMA\BicingStats\API;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\RequestOptions;

class Collector
{
    const API_ENDPOINT = 'https://www.bicing.cat/availability_map/getJsonObject';

    /**
     * @var Client
     */
    private $http;

    public function __construct()
    {
        $this->http = new Client([
            RequestOptions::HTTP_ERRORS => false,
            RequestOptions::CONNECT_TIMEOUT => 5,
            RequestOptions::TIMEOUT => 5
        ]);
    }

    /**
     * @return Response|false
     */
    public function __invoke()
    {
        $request = new Request('GET', static::API_ENDPOINT);
        $response = $this->http->send($request);

        if (! $response instanceof Response || 200 !== $response->getStatusCode()) {
            return false;
        }

        return $response;
    }
}
