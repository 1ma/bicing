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
     * @return false|StationData[]
     */
    public function __invoke()
    {
        $req = new Request('GET', static::API_ENDPOINT);
        $res = $this->http->send($req);

        if (! $res instanceof Response || 200 !== $res->getStatusCode()) {
            return false;
        }

        $stations = [];
        $collectedAt = new \DateTimeImmutable('now');
        foreach (json_decode((string)$res->getBody(), true) as $rawEntry) {
            $stations[] = new StationData(
                (int)$rawEntry['id'],
                (int)$rawEntry['bikes'],
                (int)$rawEntry['slots'],
                $collectedAt
            );
        }

        return $stations;
    }
}
