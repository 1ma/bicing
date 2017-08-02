<?php

use Slim\Container;
use UMA\BicingStats\API\Collector;

/** @var Container $cnt */
$cnt = require_once __DIR__ . '/../app/modes/cli.php';

$rawData = $cnt[Collector::class]();

echo implode("\t", array_keys($rawData[0])) . "\n";

foreach ($rawData as $station) {
    echo implode("\t", $station) . "\n";
}
