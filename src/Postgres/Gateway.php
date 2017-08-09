<?php

declare(strict_types=1);

namespace UMA\BicingStats\Postgres;

class Gateway
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
          'INSERT INTO observations (station_id, bikes, slots, observed_at) VALUES '
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

    public function getStationData(int $stationId): array
    {
        $stmt = $this->rw->prepare('
          SELECT
            bikes,
            slots,
            extract(EPOCH FROM observed_at) as date
          FROM observations
          WHERE station_id = :id
          ORDER BY observed_at ASC
        ');

        $stmt->execute(['id' => $stationId]);

        return $stmt->fetchAll();
    }

    public function getMetaData(): array
    {
        $stmt = $this->rw->query('
          SELECT id, type, lat, lng, address
          FROM stations
          WHERE is_open IS TRUE
          ORDER BY id ASC
        ');

        return $stmt->fetchAll();
    }
}