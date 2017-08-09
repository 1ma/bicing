<?php

declare(strict_types=1);

namespace UMA\BicingStats\Slim;

use Slim\Http\Request;
use Slim\Http\Response;
use UMA\BicingStats\Postgres\Mapper;

class StationAction
{
    /**
     * @var Mapper
     */
    private $mapper;

    public function __construct(Mapper $mapper)
    {
        $this->mapper = $mapper;
    }

    public function getStationData(Request $request, Response $response, array $args)
    {
        return $response->withJson(
            $this->mapper->getStationData((int) $args['id'])
        );
    }

    public function getMetaData(Request $request, Response $response, array $args)
    {
        return $response->withJson(
            $this->mapper->getMetaData()
        );
    }
}
