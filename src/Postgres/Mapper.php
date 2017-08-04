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

    public function addBatchOfShit(APIResponse $response)
    {
        $params = [];
        foreach ($response as $dataPoint) {
            $params[] = $dataPoint->getStationId();
            $params[] = $dataPoint->getBikes();
            $params[] = $dataPoint->getSlots();
            $params[] = $dataPoint->getObservedAt();
        }

        $insert = 'INSERT INTO recent_observations (observed_at, station_id, bikes, slots) VALUES '
            . implode(',', array_fill(0, count($response), '(?,?,?,?)'));

        $stmt = $this->rw->prepare($insert);

        $success = $stmt->execute($params);

        return $stmt->fetchAll();
    }
}
