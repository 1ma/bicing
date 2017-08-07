<?php

use UMA\BicingStats\Postgres\Mapper;

require_once __DIR__ . '/../vendor/autoload.php';


define('BCN_TIMEZONE', 'Europe/Andorra');
date_default_timezone_set(BCN_TIMEZONE);

$cnt = new \Slim\Container(['settings' => require_once __DIR__ . '/settings.php']);

$cnt['paths.root'] = realpath(__DIR__ . '/..');
$cnt['paths.datastore'] = $cnt['paths.root'] . '/var/data';

$cnt[\PDO::class] = function ($cnt) {
    $pdo = new \PDO($cnt['settings']['pdo']['dsn'], null, null, [
        \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
        \PDO::ATTR_EMULATE_PREPARES => false,
        \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION
    ]);

    $pdo->exec(sprintf("SET TIMEZONE TO '%s'", BCN_TIMEZONE));

    return $pdo;
};

$cnt[Mapper::class] = function ($cnt) {
    return new Mapper($cnt[\PDO::class]);
};

return $cnt;
