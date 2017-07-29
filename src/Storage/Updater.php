<?php

declare(strict_types=1);

namespace UMA\BicingStats\Storage;

use UMA\BicingStats\API\Collector;

class Updater
{
    /**
     * @var Collector
     */
    private $collector;

    public function __construct(Collector $collector)
    {
        $this->collector = $collector;
    }

    public function __invoke()
    {
        $collector = $this->collector;

        if (false === $stations = $collector()) {
            return;
        }

        foreach ($stations as $station) {
            $fh = Locking::getWritingLockOn(DATA_DIR."/{$station->getId()}.dat");

            fwrite($fh, (string)$station."\n");

            Locking::scrap($fh);
        }
    }
}
