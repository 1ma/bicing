<?php

declare(strict_types=1);

namespace UMA\Bicing\Slim;

use Slim\Exception\NotFoundException;
use Slim\Http\Request;
use Slim\Http\Response;
use UMA\Bicing\Postgres\ObservationMapper;
use UMA\Bicing\Postgres\StationMapper;

class ObservationsAction
{
    const ROUTE = '/stations/{id:[0-9]{1,3}}';

    /**
     * @var ObservationMapper
     */
    private $mapper;

    public function __construct(ObservationMapper $mapper)
    {
        $this->mapper = $mapper;
    }

    public function __invoke(Request $request, Response $response, array $args)
    {
        if ([] === $stationData = $this->mapper->getStationData((int) $args['id'])) {
            throw new NotFoundException($request, $response);
        }

        return $response->withJson($stationData);
    }
}
