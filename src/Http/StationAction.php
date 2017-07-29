<?php

declare(strict_types=1);

namespace UMA\BicingStats\Http;

use Slim\Http\Request;
use Slim\Http\Response;
use UMA\BicingStats\Storage\Reader;

class StationAction
{
    const ROUTE = '/stations/{id:[0-9]{1,3}}';

    /**
     * @var Reader
     */
    private $reader;

    public function __construct(Reader $reader)
    {
        $this->reader = $reader;
    }

    public function __invoke(Request $request, Response $response, array $args)
    {
        $reader = $this->reader;

        if (false === $data = $reader((int)$args['id'])) {
            return $response->withStatus(404);
        }

        $response->getBody()->write($data);

        return $response->withHeader('Content-Type', 'text/csv');
    }
}
