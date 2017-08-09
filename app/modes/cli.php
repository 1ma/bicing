<?php

use Slim\Container;
use UMA\Bicing\API\Collector;
use UMA\Bicing\Postgres\Gateway;
use UMA\Bicing\Updater;

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
