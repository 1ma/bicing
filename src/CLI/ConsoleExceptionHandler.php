<?php

namespace UMA\Bicing\CLI;

class ConsoleExceptionHandler
{
    public function __invoke(\Throwable $t)
    {
        echo "wut\n";
    }
}
