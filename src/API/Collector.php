<?php

declare(strict_types=1);

namespace UMA\BicingStats\API;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\TransferException;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\RequestOptions;
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

    public function __construct(string $apiContractPath)
    {
        $this->apiContract = (object)['$ref' => "file://$apiContractPath"];
        $this->http = new Client([
            RequestOptions::HTTP_ERRORS => false,
            RequestOptions::CONNECT_TIMEOUT => 5,
            RequestOptions::TIMEOUT => 5
        ]);
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
