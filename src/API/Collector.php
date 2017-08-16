<?php

declare(strict_types=1);

namespace UMA\Bicing\API;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\TransferException;
use JsonSchema\Validator;
use UMA\Bicing\Model\Observation;

class Collector
{
    const API_ENDPOINT = 'https://www.bicing.cat/availability_map/getJsonObject';

    /**
     * @var \stdClass
     */
    private $apiContract;

    /**
     * @var Client
     */
    private $http;

    public function __construct(Client $http, string $apiContractPath)
    {
        $this->http = $http;
        $this->apiContract = (object)['$ref' => "file://$apiContractPath"];
    }

    public function __invoke(): ?Observation
    {
        try {
            $response = $this->http->get(static::API_ENDPOINT);
        } catch (TransferException $e) {
            return null;
        }

        if (200 !== $response->getStatusCode()) {
            return null;
        }

        $decodedResponse = json_decode((string) $response->getBody());

        if (JSON_ERROR_NONE !== json_last_error()) {
            return null;
        }

        $validator = new Validator();
        $validator->check($decodedResponse, $this->apiContract);

        if (!$validator->isValid()) {
            return null;
        }

        return new Observation($decodedResponse);
    }
}
