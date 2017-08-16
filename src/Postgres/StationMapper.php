<?php

declare(strict_types=1);

namespace UMA\Bicing\Postgres;

use UMA\Bicing\Model\Station;

class StationMapper
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
     * @return Station[]
     */
    public function getCurrentStations(): array
    {
        $stmt = $this->rw->query('
          SELECT id, is_open, type, lat, lng, address
          FROM stations
        ');

        $stations = [];
        while ($row = $stmt->fetch()) {
            $stations[$row['id']] = new Station(
                $row['id'],
                $row['type'],
                $row['is_open'],
                $row['lat'],
                $row['lng'],
                $row['address']
            );
        }

        return $stations;
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

    public function save(Station $station): bool
    {
        $stmt = $this->rw->prepare('
          INSERT INTO stations (id, is_open, type, lat, lng, address)
          VALUES (:id, :open, :type, :lat, :lng, :address)
          ON CONFLICT (id) DO 
            UPDATE SET (is_open, type, lat, lng, address) = (:open, :type, :lat, :lng, :address)
            WHERE stations.id = :id
        ');

        $stmt->bindValue('id', $station->getId(), \PDO::PARAM_INT);
        $stmt->bindValue('open', $station->isOpen(), \PDO::PARAM_BOOL);
        $stmt->bindValue('type', $station->getType());
        $stmt->bindValue('lat', $station->getLat());
        $stmt->bindValue('lng', $station->getLng());
        $stmt->bindValue('address', $station->getAddress());

        return $stmt->execute();
    }
}
