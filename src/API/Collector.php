<?php

declare(strict_types=1);

namespace UMA\Bicing\API;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\TransferException;
use GuzzleHttp\Psr7\Request;
use JsonSchema\Validator;

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

    /**
     * @var Validator
     */
    private $validator;

    public function __construct(Client $http, string $apiContractPath)
    {
        $this->http = $http;
        $this->apiContract = (object)['$ref' => "file://$apiContractPath"];
        $this->validator = new Validator();
    }

    /**
     * @return \stdClass[]|false
     */
    public function __invoke()
    {
        try {
            $response = $this->http->send(
                new Request('GET', static::API_ENDPOINT)
            );
        } catch (TransferException $e) {
            return false;
        }

        if (200 !== $response->getStatusCode()) {
            return false;
        }

        $decodedResponse = json_decode((string) $response->getBody());

        if (JSON_ERROR_NONE !== json_last_error()) {
            return false;
        }

        $this->validator->check($decodedResponse, $this->apiContract);

        if (!$this->validator->isValid()) {
            return false;
        }

        return $decodedResponse;
    }
}
