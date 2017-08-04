<?php

use UMA\BicingStats\Postgres\Mapper;

date_default_timezone_set('Europe/Andorra');

require_once __DIR__ . '/../vendor/autoload.php';

$cnt = new \Slim\Container(['settings' => require_once __DIR__ . '/settings.php']);

$cnt['paths.root'] = realpath(__DIR__ . '/..');
$cnt['paths.datastore'] = $cnt['paths.root'] . '/var/data';

$cnt[\PDO::class] = function ($cnt) {
    return new \PDO($cnt['settings']['pdo']['dsn'], null, null, [
        \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
        \PDO::ATTR_EMULATE_PREPARES => false,
        \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION
    ]);
};

$cnt[Mapper::class] = function ($cnt) {
    return new Mapper($cnt[\PDO::class]);
};

return $cnt;
