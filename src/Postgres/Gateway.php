<?php

declare(strict_types=1);

namespace UMA\Bicing\Postgres;

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
    public function recordObservation(array $observation): bool
    {
        $stmt = $this->rw->prepare(
          'INSERT INTO observations (station_id, bikes, slots, observed_at) VALUES '
            . str_pad('', 10*count($observation) - 1, '(?,?,?,?),')
        );

        $params = [];
        $now = (new \DateTimeImmutable)->format(\DateTime::ATOM);
        foreach ($observation as $station) {
            $params[] = $station->id;
            $params[] = $station->bikes;
            $params[] = $station->slots;
            $params[] = $now;
        }

        return $stmt->execute($params);
    }

    public function recordFailedObservation(): bool
    {
        $now = (new \DateTimeImmutable)->format(\DateTime::ATOM);

        $stmt = $this->rw->prepare('
          INSERT INTO observations (station_id, bikes, slots, observed_at)
            SELECT
              id AS station_id,
              NULL AS bikes,
              NULL AS slots,
              :now AS observed_at
            FROM stations
        ');

        return $stmt->execute(['now' => $now]);
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

    public function archiveOldObservations(\DateTimeImmutable $threshold): int
    {
        $stmt = $this->rw->prepare('
          WITH olden AS (
            DELETE FROM observations
            WHERE observed_at < :threshold

            RETURNING *
          ) INSERT INTO historical_observations
              SELECT * FROM olden;
        ');

        $stmt->execute(['threshold' => $threshold->format(\DateTime::ATOM)]);

        return $stmt->rowCount();
    }
}
