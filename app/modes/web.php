<?php

use Slim\App;
use Slim\Container;
use Slim\Views\Twig;
use UMA\BicingStats\Postgres\Mapper;
use UMA\BicingStats\Slim\StationAction;
use UMA\BicingStats\Slim\IndexAction;

/** @var Container $cnt */
$cnt = require_once __DIR__ . '/../common.php';

$cnt['paths.templates'] = $cnt['paths.root'] . '/res/templates';

$cnt[Twig::class] = function ($cnt) {
    return new Twig($cnt['paths.templates']);
};

$cnt[IndexAction::class] = function ($cnt) {
    return new IndexAction($cnt[Twig::class], $cnt['settings']['openStreetMap']['accessToken']);
};

$cnt[StationAction::class] = function ($cnt) {
    return new StationAction($cnt[Mapper::class]);
};

$cnt[App::class] = function ($cnt) {
    $app = new App($cnt);

    $app->get('/', IndexAction::class);
    $app->get('/stations', StationAction::class . ':getMetaData');
    $app->get('/stations/{id:[0-9]{1,3}}', StationAction::class . ':getStationData');

    return $app;
};

return $cnt;
