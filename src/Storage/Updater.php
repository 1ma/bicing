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

    /**
     * @var string
     */
    private $dataDir;

    public function __construct(Collector $collector, string $dataDir)
    {
        $this->collector = $collector;
        $this->dataDir = $dataDir;
    }

    public function __invoke()
    {
        $collector = $this->collector;

        if (false === $stationData = $collector()) {
            return;
        }

        $updatedAt = new \DateTimeImmutable('now');
        foreach ($stationData as $station) {
            $fh = Locking::getWritingLockOn("{$this->dataDir}/{$station['id']}.tsv");

            fwrite($fh, "{$updatedAt->getTimestamp()}\t{$station['bikes']}\t{$station['slots']}\n");

            Locking::unlock($fh);
        }
    }
}
