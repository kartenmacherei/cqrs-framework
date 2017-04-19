<?php
namespace Kartenmacherei\CQRSFramework;

use Kartenmacherei\CQRSFramework\ApplicationState\StateDataService;
use Kartenmacherei\CQRSFramework\Request\Request;
use Kartenmacherei\CQRSFramework\Response\Response;
use Kartenmacherei\CQRSFramework\Routing\GetRoute\GetRoute;
use Kartenmacherei\CQRSFramework\Routing\GetRoute\GetRouteChain;
use Kartenmacherei\CQRSFramework\Routing\PostRoute\PostRoute;
use Kartenmacherei\CQRSFramework\Routing\PostRoute\PostRouteChain;
use Kartenmacherei\CQRSFramework\Routing\RequestHandlerLocator;
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
     * @param array $config
     * @return Framework
     */
    public static function createInstance($config = []): Framework
    {
        $config = new CQRSConfig($config);

        $factory = new Factory($config->tmpStateDataDirectory());

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