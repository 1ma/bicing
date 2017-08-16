<?php

namespace UMA\Bicing\CLI;

use Psr\Log\LoggerInterface;

class ConsoleExceptionHandler
{
    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * @var \PDO
     */
    private $rw;

    public function __construct(LoggerInterface $logger, \PDO $rw)
    {
        $this->logger = $logger;
        $this->rw = $rw;
    }

    public function __invoke(\Throwable $t)
    {
        $this->logger->error($t);

        if ($this->rw->inTransaction()) {
            $this->rw->rollBack();
        }
    }
}
