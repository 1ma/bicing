<?php

declare(strict_types=1);

namespace UMA\BicingStats\Storage;

use UMA\BicingStats\API\Collector;
use UMA\BicingStats\Postgres\Mapper;

class Updater
{
    /**
     * @var Collector
     */
    private $collector;

    /**
     * @var Mapper
     */
    private $mapper;

    public function __construct(Collector $collector, Mapper $mapper)
    {
        $this->collector = $collector;
        $this->mapper = $mapper;
    }

    public function __invoke(): bool
    {
        $collector = $this->collector;

        if (false === $stationData = $collector()) {
            return false;
        }

        return $this->mapper->appendObservation($stationData);
    }
}
