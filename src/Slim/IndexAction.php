<?php

declare(strict_types=1);

namespace UMA\Bicing\Slim;

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

    /**
     * @var string
     */
    private $accessToken;

    public function __construct(Twig $twig, string $accessToken)
    {
        $this->twig = $twig;
        $this->accessToken = $accessToken;
    }

    public function __invoke(Request $request, Response $response)
    {
        return $this->twig->render($response, 'index.html.twig', ['osm_access_token' => $this->accessToken]);
    }
}
