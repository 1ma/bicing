<?php

use Slim\Container;
use UMA\BicingStats\API\Collector;

/** @var Container $cnt */
$cnt = require_once __DIR__ . '/../app/modes/cli.php';

echo json_encode($cnt[Collector::class]());
