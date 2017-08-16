<?php

namespace UMA\Bicing\CLI;

use Psr\Log\LoggerInterface;

class ConsoleExceptionHandler
{
    /**
     * @var LoggerInterface
     */
    private $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function __invoke(\Throwable $t)
    {
        $this->logger->error($t);
    }
}
