<?php

use Slim\Container;
use UMA\BicingStats\API\Collector;
use UMA\BicingStats\Storage\Updater;

/** @var Container $cnt */
$cnt = require_once __DIR__ . '/../common.php';

$cnt[Collector::class] = function () {
    return new Collector();
};

$cnt[Updater::class] = function ($cnt) {
    return new Updater($cnt[Collector::class], $cnt['paths.datastore']);
};

return $cnt;
