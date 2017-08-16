<?php

use Slim\App;
use Slim\Container;
use Slim\Views\Twig;
use UMA\Bicing\Postgres\ObservationMapper;
use UMA\Bicing\Postgres\StationMapper;
use UMA\Bicing\Slim\SimpleHttpExceptionHandler;
use UMA\Bicing\Slim\StationController;
use UMA\Bicing\Slim\IndexAction;

/** @var Container $cnt */
$cnt = require_once __DIR__ . '/../common.php';

$cnt['paths.templates'] = $cnt['paths.root'] . '/res/templates';

$cnt[Twig::class] = function ($cnt) {
    return new Twig($cnt['paths.templates']);
};

$cnt[IndexAction::class] = function ($cnt) {
    return new IndexAction($cnt[Twig::class], $cnt['settings']['openStreetMap']['accessToken']);
};

$cnt[StationController::class] = function ($cnt) {
    return new StationController($cnt[StationMapper::class], $cnt[ObservationMapper::class]);
};

$cnt['notFoundHandler'] = function () {
    return new SimpleHttpExceptionHandler(404);
};

$cnt['notAllowedHandler'] = function () {
    return new SimpleHttpExceptionHandler(405);
};

$cnt['errorHandler'] = function () {
    return new SimpleHttpExceptionHandler(500);
};

$cnt[App::class] = function ($cnt) {
    $app = new App($cnt);

    $app->get(IndexAction::ROUTE, IndexAction::class);
    $app->get(StationController::ROUTE_META, StationController::class . ':getMetaData');
    $app->get(StationController::ROUTE_STATION, StationController::class . ':getStationData');

    return $app;
};

return $cnt;
