<?php

declare(strict_types=1);

namespace UMA\BicingStats\API;

use JsonSchema\Validator;
use Psr\Http\Message\ResponseInterface;

class APIResponse implements \Countable, \Iterator
{
    /**
     * @var DataPoint[]
     */
    private $dataPoints;

    public function __construct(ResponseInterface $response, \DateTimeImmutable $receivedAt, string $apiContractPath)
    {
        $parsedResponse = json_decode((string)$response->getBody());
        if (JSON_ERROR_NONE !== json_last_error()) {
            throw new \RuntimeException('wtf is this shit');
        }

        $validatron = new Validator();
        $validatron->validate($parsedResponse, (object)['$ref' => "file://$apiContractPath"]);

        if (false === $validatron->isValid()) {
            throw new \RuntimeException('srsly nao');
        }

        $this->dataPoints = [];
        foreach ($parsedResponse as $stationData) {
            $this->dataPoints[] = new DataPoint(
                (int)$stationData->id,
                (int)$stationData->bikes,
                (int)$stationData->slots,
                $receivedAt
            );
        }
    }

    /**
     * {@inheritdoc}
     */
    public function count()
    {
        return count($this->dataPoints);
    }

    /**
     * {@inheritdoc}
     */
    public function current(): ?DataPoint
    {
        if (false === $current = current($this->dataPoints)) {
            return null;
        }

        return $current;
    }

    /**
     * {@inheritdoc}
     */
    public function next()
    {
        next($this->dataPoints);
    }

    /**
     * {@inheritdoc}
     */
    public function key()
    {
        return key($this->dataPoints);
    }

    /**
     * {@inheritdoc}
     */
    public function valid()
    {
        return false !== current($this->dataPoints);
    }

    /**
     * {@inheritdoc}
     */
    public function rewind()
    {
        reset($this->dataPoints);
    }
}
