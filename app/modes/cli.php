<?php

use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;
use Slim\Container;
use UMA\Bicing\API\Collector;
use UMA\Bicing\CLI\ConsoleExceptionHandler;
use UMA\Bicing\Postgres\ObservationMapper;
use UMA\Bicing\Updater;

/** @var Container $cnt */
$cnt = require_once __DIR__ . '/../common.php';

$cnt['paths.contracts'] = $cnt['paths.root'] . '/res/contracts';

$cnt[Client::class] = function ($cnt) {
    return new Client([
        RequestOptions::HTTP_ERRORS => false,
        RequestOptions::CONNECT_TIMEOUT => $cnt['settings']['guzzle']['connectionTimeout'],
        RequestOptions::TIMEOUT => $cnt['settings']['guzzle']['requestTimeout']
    ]);
};

$cnt[Collector::class] = function ($cnt) {
    return new Collector(
        $cnt[Client::class],
        $cnt['paths.contracts'] . '/bicing-api-contract.json'
    );
};

$cnt[Updater::class] = function ($cnt) {
    return new Updater($cnt[Collector::class], $cnt[ObservationMapper::class]);
};

$cnt[ConsoleExceptionHandler::class] = function () {
    return new ConsoleExceptionHandler();
};

set_exception_handler($cnt[ConsoleExceptionHandler::class]);

return $cnt;
