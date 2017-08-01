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

        $mh = Locking::getWritingLockOn("{$this->dataDir}/meta.tsv", false);
        fwrite($mh, "id\tlat\tlng\taddress\n");

        $updatedAt = new \DateTimeImmutable('now');
        foreach ($stationData as $station) {
            $fullAddress = $station['address'];

            if (isset($station['addressNumber'])) {
                $fullAddress .= ", {$station['addressNumber']}";
            }

            fwrite($mh, "{$station['id']}\t{$station['lat']}\t{$station['lon']}\t$fullAddress\n");

            $fh = Locking::getWritingLockOn("{$this->dataDir}/{$station['id']}.tsv", true);

            fwrite($fh, "{$updatedAt->getTimestamp()}\t{$station['bikes']}\t{$station['slots']}\n");

            Locking::unlock($fh);
        }

        Locking::unlock($mh);
    }
}
