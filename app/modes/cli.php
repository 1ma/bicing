<?php

use Slim\Container;
use UMA\BicingStats\API\Collector;
use UMA\BicingStats\Postgres\Gateway;
use UMA\BicingStats\Updater;

/** @var Container $cnt */
$cnt = require_once __DIR__ . '/../common.php';

$cnt['paths.contracts'] = $cnt['paths.root'] . '/res/contracts';

$cnt[Collector::class] = function ($cnt) {
    return new Collector($cnt['paths.contracts'] . '/bicing-api-contract.json');
};

$cnt[Updater::class] = function ($cnt) {
    return new Updater($cnt[Collector::class], $cnt[Gateway::class]);
};

return $cnt;
