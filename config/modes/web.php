<?php

use Slim\App;
use Slim\Container;
use Slim\Views\Twig;
use UMA\Bicing\Postgres\ObservationMapper;
use UMA\Bicing\Postgres\StationMapper;
use UMA\Bicing\Slim\ObservationsAction;
use UMA\Bicing\Slim\SimpleHttpExceptionHandler;
use UMA\Bicing\Slim\StationsAction;
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

$cnt[StationsAction::class] = function ($cnt) {
    return new StationsAction($cnt[StationMapper::class]);
};

$cnt[ObservationsAction::class] = function ($cnt) {
    return new ObservationsAction($cnt[ObservationMapper::class]);
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
    $app->get(StationsAction::ROUTE, StationsAction::class);
    $app->get(ObservationsAction::ROUTE, ObservationsAction::class);

    return $app;
};

return $cnt;
