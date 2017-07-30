<?php

use UMA\BicingStats\API\Collector;

require_once __DIR__ . '/../app/bootstrap.php';

$rawData = (new Collector)();

echo implode("\t", array_keys($rawData[0])) . "\n";

foreach ($rawData as $station) {
    echo implode("\t", $station) . "\n";
}
