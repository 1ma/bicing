<?php

namespace UMA\Bicing\Slim;

use Slim\Http\Request;
use Slim\Http\Response;

class SimpleHttpExceptionHandler
{
    /**
     * @var int
     */
    private $statusCode;

    public function __construct(int $statusCode)
    {
        $this->statusCode = $statusCode;
    }

    public function __invoke(Request $request, Response $response): Response
    {
        return $response->withStatus($this->statusCode);
    }
}
