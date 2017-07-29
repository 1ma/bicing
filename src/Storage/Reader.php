<?php

declare(strict_types=1);

namespace UMA\BicingStats\Storage;

class Reader
{
    public function __invoke(int $id)
    {
        if (false === $fh = Locking::getReadingLockOn(DATA_DIR . "/{$id}.dat")) {
            return false;
        }

        $data = [];
        while (false !== $line = fgets($fh)) {
            list($timestamp, $bikes, $slots) = explode(',', trim($line));

            $data[$timestamp] = ['b' => (int)$bikes, 's' => (int)$slots];
        }

        Locking::scrap($fh);

        return $data;
    }
}
