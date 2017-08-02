<?php

use Slim\App;
use Slim\Container;
use Slim\Views\Twig;
use UMA\BicingStats\Slim\StationAction;
use UMA\BicingStats\Slim\IndexAction;
use UMA\BicingStats\Storage\Reader;

/** @var Container $cnt */
$cnt = require_once __DIR__ . '/../app/bootstrap.php';

$cnt[Twig::class] = function ($cnt) {
    return new Twig($cnt['paths.templates']);
};

$cnt[IndexAction::class] = function ($cnt) {
    return new IndexAction($cnt[Twig::class], $cnt['settings']['osm']['access_token']);
};

$cnt[StationAction::class] = function ($cnt) {
    return new StationAction(new Reader($cnt['paths.datastore']));
};

$cnt[App::class] = function ($cnt) {
    $app = new App($cnt);

    $app->get('/', IndexAction::class);
    $app->get('/stations', StationAction::class);
    $app->get('/stations/{id:[0-9]{1,3}}', StationAction::class);
    return $app;
};

$cnt[App::class]->run();
