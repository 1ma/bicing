<?php

declare(strict_types=1);

namespace UMA\BicingStats\Slim;

use Slim\Http\Request;
use Slim\Http\Response;
use Slim\Views\Twig;

class IndexAction
{
    /**
     * @var Twig
     */
    private $twig;

    /**
     * @var string
     */
    private $osmAccessToken;

    public function __construct(Twig $twig, string $accessToken)
    {
        $this->twig = $twig;
        $this->osmAccessToken = $accessToken;
    }

    public function __invoke(Request $request, Response $response)
    {
        return $this->twig->render($response, 'index.html.twig', ['osm_access_token' => $this->osmAccessToken]);
    }
}
