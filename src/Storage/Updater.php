<?php

declare(strict_types=1);

namespace UMA\BicingStats\Storage;

use UMA\BicingStats\API\Collector;
use UMA\BicingStats\Postgres\Gateway;

class Updater
{
    /**
     * @var Collector
     */
    private $collector;

    /**
     * @var Gateway
     */
    private $gateway;

    public function __construct(Collector $collector, Gateway $gateway)
    {
        $this->collector = $collector;
        $this->gateway = $gateway;
    }

    public function __invoke(): bool
    {
        $collector = $this->collector;

        if (false === $stationData = $collector()) {
            return false;
        }

        return $this->gateway->appendObservation($stationData);
    }
}
