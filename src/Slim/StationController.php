<?php

declare(strict_types=1);

namespace UMA\Bicing\Slim;

use Slim\Exception\NotFoundException;
use Slim\Http\Request;
use Slim\Http\Response;
use UMA\Bicing\Postgres\ObservationMapper;
use UMA\Bicing\Postgres\StationMapper;

class StationController
{
    const ROUTE_META = '/stations';
    const ROUTE_STATION = '/stations/{id:[0-9]{1,3}}';

    /**
     * @var StationMapper
     */
    private $stationMapper;

    /**
     * @var ObservationMapper
     */
    private $observationMapper;

    public function __construct(StationMapper $stationMapper, ObservationMapper $observationMapper)
    {
        $this->observationMapper = $observationMapper;
        $this->stationMapper = $stationMapper;
    }

    public function getMetaData(Request $request, Response $response)
    {
        return $response->withJson(
            $this->stationMapper->getMetaData()
        );
    }

    public function getStationData(Request $request, Response $response, array $args)
    {
        if ([] === $stationData = $this->observationMapper->getStationData((int) $args['id'])) {
            throw new NotFoundException($request, $response);
        }

        return $response->withJson($stationData);
    }
}
