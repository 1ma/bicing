<?php

declare(strict_types=1);

namespace UMA\BicingStats\Postgres;

use UMA\BicingStats\API\APIResponse;

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

    public function appendObservation(APIResponse $response)
    {
        $stmt = $this->rw->prepare(
          'INSERT INTO recent_observations (station_id, bikes, slots, observed_at) VALUES '
            . implode(',', array_fill(0, count($response), '(?,?,?,?)'))
        );

        $params = [];
        foreach ($response as $dataPoint) {
            $params[] = $dataPoint->getStationId();
            $params[] = $dataPoint->getBikes();
            $params[] = $dataPoint->getSlots();
            $params[] = $dataPoint->getObservedAt()->format(\DateTime::ATOM);
        }

        return $stmt->execute($params) && $stmt->rowCount() === count($response);
    }
}
