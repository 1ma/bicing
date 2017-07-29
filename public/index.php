<?php

use Slim\App;
use Slim\Container;
use Slim\Views\Twig;
use UMA\BicingStats\Http\StationAction;
use UMA\BicingStats\Http\IndexAction;
use UMA\BicingStats\Storage\Reader;

/** @var Container $cnt */
$cnt = require_once __DIR__ . '/../app/bootstrap.php';

$cnt[Twig::class] = function () {
    return new Twig(TEMPLATES_DIR);
};

$cnt[IndexAction::class] = function ($cnt) {
    return new IndexAction($cnt[Twig::class]);
};

$cnt[StationAction::class] = function () {
    return new StationAction(new Reader());
};

$cnt[App::class] = function ($cnt) {
    $app = new App($cnt);

    $app->get(IndexAction::ROUTE, IndexAction::class);
    $app->get(StationAction::ROUTE, StationAction::class);

    return $app;
};

$cnt[App::class]->run();
