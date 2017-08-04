<?php

use Slim\Container;

/** @var Container $cnt */
$cnt = require_once __DIR__ . '/../app/modes/cli.php';

$response = new \UMA\BicingStats\API\APIResponse(
    (new \UMA\BicingStats\API\Collector)(),
    new DateTimeImmutable('now'),
    "{$cnt['paths.root']}/res/contracts/bicing-api-contract.json"
);

$success = $cnt[\UMA\BicingStats\Postgres\Mapper::class]->appendObservation($response);

var_dump($success);
