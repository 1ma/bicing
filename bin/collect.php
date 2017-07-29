<?php

use UMA\BicingStats\Storage\Updater;
use UMA\BicingStats\API\Collector;

require_once __DIR__ . '/../app/bootstrap.php';

(new Updater(new Collector))();
