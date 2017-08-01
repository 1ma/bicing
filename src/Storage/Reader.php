<?php

declare(strict_types=1);

namespace UMA\BicingStats\Storage;

class Reader
{
    /**
     * @var string
     */
    private $dataDir;

    public function __construct(string $dataDir)
    {
        $this->dataDir = $dataDir;
    }

    /**
     * @param int $id
     *
     * @return bool|string
     */
    public function __invoke(int $id)
    {
        if (0 === $id) {
            $id = 'meta';
        }

        if (false === $fh = Locking::getReadingLockOn("{$this->dataDir}/{$id}.tsv")) {
            return false;
        }

        $data = stream_get_contents($fh);

        Locking::unlock($fh);

        return $data;
    }
}
