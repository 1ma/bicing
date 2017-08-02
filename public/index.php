<?php

use Slim\App;
use Slim\Container;

/** @var Container $cnt */
$cnt = require_once __DIR__ . '/../app/modes/web.php';

$cnt[App::class]->run();
