<?php

namespace Kartenmacherei\HttpFramework\Routing;

use Kartenmacherei\HttpFramework\Request\PostRequest;
use Kartenmacherei\HttpFramework\Request\Request;
use Kartenmacherei\HttpFramework\Response\Response;
use Kartenmacherei\HttpFramework\Routing\PostRoute\PostRouteChain;

class PostRequestHandler implements RequestHandler
{
    /**
     * @var PostRouteChain
     */
    private $postRouteChain;

    /**
     * @param PostRouteChain $postRouteChain
     */
    public function __construct(PostRouteChain $postRouteChain) {
        $this->postRouteChain = $postRouteChain;
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function handle(Request $request) : Response {

        /** @var PostRequest $request */
        $command = $this->postRouteChain->route($request);

        $response = $command->execute();

        return $response;
    }
}
