<?php

use Slim\Container;
use UMA\Bicing\Postgres\ObservationMapper;

/** @var Container $cnt */
$cnt = require_once __DIR__ . '/../config/modes/cli.php';

$threshold = (new \DateTimeImmutable)->sub(
    new \DateInterval("PT{$cnt['settings']['archival']['secondsOld']}S")
);

var_dump($cnt[ObservationMapper::class]->archiveOldObservations($threshold));
