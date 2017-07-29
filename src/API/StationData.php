<?php

declare(strict_types=1);

namespace UMA\BicingStats\API;

class StationData
{
    /**
     * @var int
     */
    private $id;

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
    private $collectedAt;

    public function __construct(int $id, int $bikes, int $slots, \DateTimeImmutable $collectedAt)
    {
        $this->id = $id;
        $this->bikes = $bikes;
        $this->slots = $slots;
        $this->collectedAt = $collectedAt;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    public function __toString()
    {
        return sprintf("%s,%s,%s", $this->collectedAt->getTimestamp(), $this->bikes, $this->slots);
    }
}
