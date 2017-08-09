<?php

use Slim\Container;
use UMA\Bicing\Postgres\Gateway;

/** @var Container $cnt */
$cnt = require_once __DIR__ . '/../app/modes/cli.php';

$threshold = (new \DateTimeImmutable)->sub(
    new \DateInterval("PT{$cnt['settings']['archival']['secondsOld']}S")
);

var_dump($cnt[Gateway::class]->archiveOldObservations($threshold));
