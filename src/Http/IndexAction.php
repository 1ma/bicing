<?php

declare(strict_types=1);

namespace UMA\BicingStats\Http;

use Slim\Http\Request;
use Slim\Http\Response;
use Slim\Views\Twig;

class IndexAction
{
    const ROUTE = '/';

    /**
     * @var Twig
     */
    private $twig;

    public function __construct(Twig $twig)
    {
        $this->twig = $twig;
    }

    public function __invoke(Request $request, Response $response)
    {
        return $this->twig->render($response, 'index.html.twig');
    }
}
