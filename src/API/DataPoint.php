<?php

declare(strict_types=1);

namespace UMA\BicingStats\API;

class DataPoint
{
    /**
     * @var int
     */
    private $stationId;

    /**
     * @var int
     */
    private $bikes;

    /**
     * @var int
     */
    private $slots;

    /**
     * @var \DateTimeImmutable
     */
    private $observedAt;

    public function __construct(int $stationId, int $bikes, int $slots, \DateTimeImmutable $observedAt)
    {
        $this->stationId = $stationId;
        $this->bikes = $bikes;
        $this->slots = $slots;
        $this->observedAt = $observedAt;
    }

    /**
     * @return int
     */
    public function getStationId(): int
    {
        return $this->stationId;
    }

    /**
     * @return int
     */
    public function getBikes(): int
    {
        return $this->bikes;
    }

    /**
     * @return int
     */
    public function getSlots(): int
    {
        return $this->slots;
    }

    /**
     * @return \DateTimeImmutable
     */
    public function getObservedAt(): \DateTimeImmutable
    {
        return $this->observedAt;
    }
}
