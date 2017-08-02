<?php

date_default_timezone_set('Europe/Andorra');

require_once __DIR__ . '/../vendor/autoload.php';

$cnt = new \Slim\Container(['settings' => require_once __DIR__ . '/settings.php']);

$cnt['paths.root'] = realpath(__DIR__ . '/..');
$cnt['paths.datastore'] = $cnt['paths.root'] . '/var/data';

return $cnt;
