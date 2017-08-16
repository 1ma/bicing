<?php

declare(strict_types=1);

namespace UMA\Bicing\Slim;

use Slim\Http\Request;
use Slim\Http\Response;
use UMA\Bicing\Postgres\StationMapper;

class StationsAction
{
    const ROUTE = '/stations';

    /**
     * @var StationMapper
     */
    private $mapper;

    public function __construct(StationMapper $mapper)
    {
        $this->mapper = $mapper;
    }

    public function __invoke(Request $request, Response $response)
    {
        return $response->withJson(
            $this->mapper->getMetaData()
        );
    }
}
