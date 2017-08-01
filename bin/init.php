<?php

use UMA\BicingStats\API\Collector;
use UMA\BicingStats\Storage\Locking;

require_once __DIR__ . '/../app/bootstrap.php';

@mkdir($cnt['paths.datastore']);

foreach (array_column((new Collector)(), 'id') as $id) {
    $fh = Locking::getWritingLockOn("{$cnt['paths.datastore']}/{$id}.tsv");

    if (0 === fstat($fh)['size']) {
        fwrite($fh, "timestamp\tbikes\tslots\n");
    }

    Locking::unlock($fh);
}

