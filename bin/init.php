<?php

use Slim\Container;
use UMA\BicingStats\API\Collector;
use UMA\BicingStats\Storage\Locking;

/** @var Container $cnt */
$cnt = require_once __DIR__ . '/../app/modes/cli.php';

@mkdir($cnt['paths.datastore']);

touch("{$cnt['paths.datastore']}/meta.tsv");

foreach (array_column($cnt[Collector::class](), 'id') as $id) {
    $fh = Locking::getWritingLockOn("{$cnt['paths.datastore']}/{$id}.tsv", true);

    if (0 === fstat($fh)['size']) {
        fwrite($fh, "timestamp\tbikes\tslots\n");
    }

    Locking::unlock($fh);
}
