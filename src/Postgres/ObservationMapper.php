<?php

declare(strict_types=1);

namespace UMA\Bicing\Postgres;

use UMA\Bicing\Model\Observation;

class ObservationMapper
{
    /**
     * @var \PDO
     */
    private $rw;

    /**
     * @var StationMapper
     */
    private $stationMapper;

    public function __construct(\PDO $rw, StationMapper $stationMapper)
    {
        $this->rw = $rw;
        $this->stationMapper = $stationMapper;
    }

    public function recordObservation(Observation $observation): bool
    {
        $stmt = $this->rw->prepare(
            'INSERT INTO observations (station_id, bikes, slots, observed_at) VALUES '
            . str_pad('', 10*count($observation) - 1, '(?,?,?,?),')
        );

        $params = [];
        $observationDate = $observation->observedAt()->format(\DateTime::ATOM);
        $currentStations = $this->stationMapper->getCurrentStations();
        foreach ($observation as $occupancyLevel) {
            $station = $occupancyLevel->getStation();

            if (!isset($currentStations[$station->getId()]) || $station != $currentStations[$station->getId()]) {
                $this->stationMapper->save($station);
            }

            $params[] = $station->getId();
            $params[] = $occupancyLevel->parkedBikes();
            $params[] = $occupancyLevel->freeSlots();
            $params[] = $observationDate;
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

        $stmt->bindValue('id', $stationId, \PDO::PARAM_INT);

        $stmt->execute();

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
