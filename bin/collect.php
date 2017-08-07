<?php

use Slim\Container;
use UMA\BicingStats\Storage\Updater;

/** @var Container $cnt */
$cnt = require_once __DIR__ . '/../app/modes/cli.php';

var_dump($cnt[Updater::class]());
