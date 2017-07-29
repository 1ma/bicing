<?php

declare(strict_types=1);

namespace UMA\BicingStats\Storage;

class Locking
{
    /**
     * @param string $file
     *
     * @return resource
     */
    public static function getWritingLockOn(string $file)
    {
        flock($ptr = fopen($file, 'ab'), LOCK_EX);

        return $ptr;
    }

    /**
     * @param string $file
     *
     * @return bool|resource
     */
    public static function getReadingLockOn(string $file)
    {
        if (!file_exists($file)) {
            return false;
        }

        flock($ptr = fopen($file, 'rb'), LOCK_SH);

        return $ptr;
    }

    /**
     * @param resource $ptr
     *
     * @return bool
     */
    public static function scrap($ptr)
    {
        if (!is_resource($ptr)) {
            return false;
        }

        flock($ptr, LOCK_UN);
        fclose($ptr);

        return true;
    }
}
