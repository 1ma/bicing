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

        if (false === $stationData = $collector()) {
            return;
        }

        $updatedAt = new \DateTimeImmutable('now');
        foreach ($stationData as $station) {
            $fh = Locking::getWritingLockOn(DATA_DIR."/{$station['id']}.dat");

            fwrite($fh, "{$updatedAt->getTimestamp()},{$station['bikes']},{$station['slots']}\n");

            Locking::unlock($fh);
        }
    }
}
