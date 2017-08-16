<?php

declare(strict_types=1);

namespace UMA\Bicing;

use UMA\Bicing\API\Collector;
use UMA\Bicing\Postgres\ObservationMapper;

class Updater
{
    /**
     * @var Collector
     */
    private $collector;

    /**
     * @var ObservationMapper
     */
    private $mapper;

    public function __construct(Collector $collector, ObservationMapper $mapper)
    {
        $this->collector = $collector;
        $this->mapper = $mapper;
    }

    public function __invoke(): bool
    {
        $collector = $this->collector;

        if (null === $observation = $collector()) {
            return $this->mapper->recordFailedObservation();
        }

        return $this->mapper->recordObservation($observation);
    }
}
