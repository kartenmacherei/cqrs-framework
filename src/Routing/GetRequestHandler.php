<?php

namespace Kartenmacherei\CQRSFramework\Routing;

use Kartenmacherei\CQRSFramework\Request\GetRequest;
use Kartenmacherei\CQRSFramework\Request\Request;
use Kartenmacherei\CQRSFramework\Response\Response;
use Kartenmacherei\CQRSFramework\Routing\GetRoute\GetRouteChain;

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