<?php

declare(strict_types=1);

namespace UMA\BicingStats\Slim;

use Slim\Exception\NotFoundException;
use Slim\Http\Request;
use Slim\Http\Response;
use UMA\BicingStats\Postgres\Mapper;

class StationController
{
    const ROUTE_META = '/stations';
    const ROUTE_STATION = '/stations/{id:[0-9]{1,3}}';

    /**
     * @var Mapper
     */
    private $mapper;

    public function __construct(Mapper $mapper)
    {
        $this->mapper = $mapper;
    }

    public function getMetaData(Request $request, Response $response)
    {
        return $response->withJson(
            $this->mapper->getMetaData()
        );
    }

    public function getStationData(Request $request, Response $response, array $args)
    {
        if ([] === $stationData = $this->mapper->getStationData((int) $args['id'])) {
            throw new NotFoundException($request, $response);
        }

        return $response->withJson($stationData);
    }
}
