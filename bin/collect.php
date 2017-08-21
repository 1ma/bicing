<?php

use Slim\Container;
use UMA\Bicing\Updater;

/** @var Container $cnt */
$cnt = require_once __DIR__ . '/../config/modes/cli.php';

var_dump($cnt[Updater::class]());
