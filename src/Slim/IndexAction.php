<?php

declare(strict_types=1);

namespace UMA\BicingStats\Slim;

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
    private $googleApiKey;

    public function __construct(Twig $twig, string $googleApiKey)
    {
        $this->twig = $twig;
        $this->googleApiKey = $googleApiKey;
    }

    public function __invoke(Request $request, Response $response)
    {
        return $this->twig->render($response, 'index.html.twig', ['ga_key' => $this->googleApiKey]);
    }
}
