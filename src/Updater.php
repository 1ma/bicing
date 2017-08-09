<?php

declare(strict_types=1);

namespace UMA\Bicing;

use UMA\Bicing\API\Collector;
use UMA\Bicing\Postgres\Gateway;

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
