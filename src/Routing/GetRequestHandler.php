<?php

namespace Kartenmacherei\HttpFramework\Routing;

use Kartenmacherei\HttpFramework\Request\GetRequest;
use Kartenmacherei\HttpFramework\Request\Request;
use Kartenmacherei\HttpFramework\Response\Response;
use Kartenmacherei\HttpFramework\Routing\GetRoute\GetRouteChain;

class GetRequestHandler implements RequestHandler
{
    /**
     * @var GetRouteChain
     */
    private $getRouteChain;

    /**
     * @param GetRouteChain $getRouteChain
     */
    public function __construct(GetRouteChain $getRouteChain)
    {
        $this->getRouteChain = $getRouteChain;
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function handle(Request $request) : Response
    {
        /** @var GetRequest $request */
        $query    = $this->getRouteChain->route($request);

        $response = $query->execute();

        return $response;
    }
}