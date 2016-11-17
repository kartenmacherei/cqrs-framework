<?php
namespace Kartenmacherei\HttpFramework;

use Kartenmacherei\HttpFramework\ApplicationState\StateDataService;
use Kartenmacherei\HttpFramework\Request\Request;
use Kartenmacherei\HttpFramework\Response\Response;
use Kartenmacherei\HttpFramework\Routing\GetRoute\GetRoute;
use Kartenmacherei\HttpFramework\Routing\GetRoute\GetRouteChain;
use Kartenmacherei\HttpFramework\Routing\PostRoute\PostRouteChain;
use Kartenmacherei\HttpFramework\Routing\RequestHandlerLocator;
use Kartenmacherei\HttpFramework\Routing\Routing\PostRoute\PostRoute;
use RuntimeException;

class Framework
{
    /**
     * @var StateDataService
     */
    private $stateDataService;

    /**
     * @var GetRouteChain
     */
    private $getRouteChain;

    /**
     * @var PostRouteChain
     */
    private $postRouteChain;

    /**
     * @var RequestHandlerLocator
     */
    private $requestHandlerLocator;

    /**
     * @param StateDataService $applicationState
     * @param GetRouteChain $getRouteChain
     * @param PostRouteChain $postRouteChain
     * @param RequestHandlerLocator $requestHandlerLocator
     */
    public function __construct(
        StateDataService $applicationState,
        GetRouteChain $getRouteChain,
        PostRouteChain $postRouteChain,
        RequestHandlerLocator $requestHandlerLocator
    ) {
        $this->stateDataService = $applicationState;
        $this->getRouteChain = $getRouteChain;
        $this->postRouteChain = $postRouteChain;
        $this->requestHandlerLocator = $requestHandlerLocator;
    }

    /**
     * @return Framework
     */
    public static function createInstance(): Framework
    {
        $factory = new Factory('tmpStateData');

        return new self(
            $factory->createApplicationState(),
            $factory->createGetRouteChain(),
            $factory->createPostRouteChain(),
            $factory->createRequestHandlerLocator(),
            $factory->createApplicationState()
        );
    }

    /**
     * @param GetRoute $route
     */
    public function registerGetRoute(GetRoute $route) {
        $this->getRouteChain->add($route);
    }

    /**
     * @param PostRoute $route
     */
    public function registerPostRoute(PostRoute $route) {
        $this->postRouteChain->add($route);
    }

    /**
     * @param Request $request
     * @return Response
     * @throws RuntimeException
     */
    public function run(Request $request) : Response
    {
        $stateData = $this->stateDataService->loadData($request->sessionId());

        $request->setStateData($stateData);

        $handler = $this->requestHandlerLocator->locateHandler($request);

        $response = $handler->handle($request);

        $this->stateDataService->save($stateData);

        $response->setSessionId($request->stateData()->sessionId());

        return $response;
    }
}