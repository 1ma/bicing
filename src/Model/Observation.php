<?php

declare(strict_types=1);

namespace UMA\Bicing\Model;

class Observation implements \Countable, \Iterator
{
    private const STATUS_MAP = [
        'OPN' => true,
        'CLS' => false
    ];

    private const TYPE_MAP = [
        'BIKE' => 'regular',
        'ELECTRIC_BIKE' => 'electric'
    ];

    /**
     * @var \DateTimeImmutable
     */
    private $observedAt;

    /**
     * @var \stdClass[]
     */
    private $rawData;

    /**
     * @param \stdClass[] $parsedAndValidatedJSON
     */
    public function __construct(array $parsedAndValidatedJSON)
    {
        $this->rawData = $parsedAndValidatedJSON;
        $this->observedAt = new \DateTimeImmutable;
    }

    public function observedAt(): \DateTimeImmutable
    {
        return $this->observedAt;
    }

    /**
     * {@inheritdoc}
     */
    public function count()
    {
        return count($this->rawData);
    }

    /**
     * {@inheritdoc}
     *
     * @return Occupancy
     */
    public function current()
    {
        $data = current($this->rawData);

        $address = $data->address;
        if (isset($data->addressNumber)) {
            $address .= ", {$data->addressNumber}";
        }

        return new Occupancy(
            new Station(
                (int) $data->id,
                self::TYPE_MAP[$data->stationType],
                self::STATUS_MAP[$data->status],
                $data->lat,
                $data->lon,
                $address
            ),
            (int) $data->bikes,
            (int) $data->slots
        );
    }

    /**
     * {@inheritdoc}
     */
    public function next()
    {
        next($this->rawData);
    }

    /**
     * {@inheritdoc}
     */
    public function key()
    {
       key($this->rawData);
    }

    /**
     * {@inheritdoc}
     */
    public function valid()
    {
        return false !== current($this->rawData);
    }

    /**
     * {@inheritdoc}
     */
    public function rewind()
    {
        reset($this->rawData);
    }
}
