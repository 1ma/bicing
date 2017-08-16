<?php

declare(strict_types=1);

namespace UMA\Bicing\Model;

class Station
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $type;

    /**
     * @var bool
     */
    private $isOpen;

    /**
     * @var string
     */
    private $lat;

    /**
     * @var string
     */
    private $lng;

    /**
     * @var string
     */
    private $address;

    public function __construct(int $id, string $type, bool $isOpen, string $lat, string $lng, string $address)
    {
        $this->id = $id;
        $this->type = $type;
        $this->isOpen = $isOpen;
        $this->lat = $lat;
        $this->lng = $lng;
        $this->address = $address;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function isOpen(): bool
    {
        return $this->isOpen;
    }

    public function getLat(): string
    {
        return $this->lat;
    }

    public function getLng(): string
    {
        return $this->lng;
    }

    public function getAddress(): string
    {
        return $this->address;
    }
}
