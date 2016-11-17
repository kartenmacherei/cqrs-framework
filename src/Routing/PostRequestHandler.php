<?php

namespace Kartenmacherei\CQRSFramework\Routing;

use Kartenmacherei\CQRSFramework\Request\PostRequest;
use Kartenmacherei\CQRSFramework\Request\Request;
use Kartenmacherei\CQRSFramework\Response\Response;
use Kartenmacherei\CQRSFramework\Routing\PostRoute\PostRouteChain;

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
