<?php

date_default_timezone_set('Europe/Andorra');

define('ROOT_DIR', realpath(__DIR__) . '/..');
define('DATA_DIR', ROOT_DIR . '/var/data');
define('TEMPLATES_DIR', ROOT_DIR . '/res/templates');

require_once ROOT_DIR . '/vendor/autoload.php';

$cnt = new \Slim\Container(['settings' => require_once __DIR__ . '/settings.php']);

return $cnt;
