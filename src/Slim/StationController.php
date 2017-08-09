<?php

declare(strict_types=1);

namespace UMA\Bicing\Slim;

use Slim\Exception\NotFoundException;
use Slim\Http\Request;
use Slim\Http\Response;
use UMA\Bicing\Postgres\Gateway;

class StationController
{
    const ROUTE_META = '/stations';
    const ROUTE_STATION = '/stations/{id:[0-9]{1,3}}';

    /**
     * @var Gateway
     */
    private $gateway;

    public function __construct(Gateway $gateway)
    {
        $this->gateway = $gateway;
    }

    public function getMetaData(Request $request, Response $response)
    {
        return $response->withJson(
            $this->gateway->getMetaData()
        );
    }

    public function getStationData(Request $request, Response $response, array $args)
    {
        if ([] === $stationData = $this->gateway->getStationData((int) $args['id'])) {
            throw new NotFoundException($request, $response);
        }

        return $response->withJson($stationData);
    }
}
