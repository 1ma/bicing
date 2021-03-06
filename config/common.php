<?php

use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Psr\Log\LoggerInterface;
use UMA\Bicing\Postgres\ObservationMapper;
use UMA\Bicing\Postgres\StationMapper;

require_once __DIR__ . '/../vendor/autoload.php';


define('BCN_TIMEZONE', 'Europe/Andorra');
date_default_timezone_set(BCN_TIMEZONE);

$cnt = new \Slim\Container(['settings' => require_once __DIR__ . '/settings.php']);

$cnt['paths.root'] = realpath(__DIR__ . '/..');

$cnt[\PDO::class] = function ($cnt) {
    $pdo = new \PDO($cnt['settings']['pdo']['dsn'], null, null, [
        \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
        \PDO::ATTR_EMULATE_PREPARES => false,
        \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION
    ]);

    $pdo->exec(sprintf("SET TIMEZONE TO '%s'", BCN_TIMEZONE));

    return $pdo;
};

$cnt[LoggerInterface::class] = function () {
    $logger = new Logger('bicing');
    $logger->pushHandler(new StreamHandler('php://stdout'));

    return $logger;
};

$cnt[StationMapper::class] = function ($cnt) {
    return new StationMapper($cnt[\PDO::class]);
};

$cnt[ObservationMapper::class] = function ($cnt) {
    return new ObservationMapper($cnt[\PDO::class], $cnt[StationMapper::class]);
};

return $cnt;
