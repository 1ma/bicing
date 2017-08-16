<?php

declare(strict_types=1);

namespace UMA\Bicing\Model;

class Occupancy
{
    /**
     * @var Station
     */
    private $station;

    /**
     * @var int
     */
    private $bikes;

    /**
     * @var int
     */
    private $slots;

    public function __construct(Station $station, int $bikes, int $slots)
    {
        $this->station = $station;
        $this->bikes = $bikes;
        $this->slots = $slots;
    }

    public function getStation(): Station
    {
        return $this->station;
    }

    public function parkedBikes(): int
    {
        return $this->bikes;
    }

    public function freeSlots(): int
    {
        return $this->slots;
    }
}
