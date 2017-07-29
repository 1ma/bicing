<?php

declare(strict_types=1);

namespace UMA\BicingStats\Storage;

class Reader
{
    /**
     * @param int $id
     *
     * @return bool|string
     */
    public function __invoke(int $id)
    {
        if (false === $fh = Locking::getReadingLockOn(DATA_DIR . "/{$id}.dat")) {
            return false;
        }

        $data = stream_get_contents($fh);

        Locking::unlock($fh);

        return $data;
    }
}
