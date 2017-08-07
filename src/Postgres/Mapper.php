<?php

declare(strict_types=1);

namespace UMA\BicingStats\Postgres;

class Mapper
{
    /**
     * @var \PDO
     */
    private $rw;

    public function __construct(\PDO $rw)
    {
        $this->rw = $rw;
    }

    /**
     * @param \stdClass[] $observation
     *
     * @return bool
     */
    public function appendObservation(array $observation): bool
    {
        $stmt = $this->rw->prepare(
          'INSERT INTO recent_observations (station_id, bikes, slots, observed_at) VALUES '
            . str_pad('', 10*count($observation) - 1, '(?,?,?,?),')
        );

        $params = [];
        $observedAt = (new \DateTimeImmutable)->format(\DateTime::ATOM);
        foreach ($observation as $station) {
            $params[] = $station->id;
            $params[] = $station->bikes;
            $params[] = $station->slots;
            $params[] = $observedAt;
        }

        return $stmt->execute($params);
    }
}
