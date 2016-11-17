<?php

namespace Kartenmacherei\HttpFramework;

use Kartenmacherei\HttpFramework\ApplicationState\StateDataFileLoader;
use Kartenmacherei\HttpFramework\ApplicationState\StateDataFileWriter;
use Kartenmacherei\HttpFramework\ApplicationState\StateDataService;
use Kartenmacherei\HttpFramework\Library\File\Directory;
use Kartenmacherei\HttpFramework\Routing\GetRequestHandler;
use Kartenmacherei\HttpFramework\Routing\GetRoute\GetRouteChain;
use Kartenmacherei\HttpFramework\Routing\PostRequestHandler;
use Kartenmacherei\HttpFramework\Routing\PostRoute\PostRouteChain;
use Kartenmacherei\HttpFramework\Routing\RequestHandlerLocator;

class Factory
{
    /**
     * @var Directory
     */
    private $stateDataDirectory;

    /**
     * @var GetRouteChain
     */
    private $getRouteChain;

    /**
     * @var PostRouteChain
     */
    private $postRouteChain;


    /**
     * @param string $stateDataDirectory
     */
    public function __construct($stateDataDirectory)
    {
        $this->stateDataDirectory = new Directory($stateDataDirectory);
    }


    /**
     * @return GetRouteChain
     */
    public function createGetRouteChain() : GetRouteChain
    {
        if (is_null($this->getRouteChain)) {
            $this->getRouteChain = new GetRouteChain();
        }
        return $this->getRouteChain;
    }

    /**
     * @return PostRouteChain
     */
    public function createPostRouteChain() : PostRouteChain
    {
        if (is_null($this->postRouteChain)) {
            $this->postRouteChain = new PostRouteChain();
        }
        return $this->postRouteChain;
    }

    /**
     * @return RequestHandlerLocator
     */
    public function createRequestHandlerLocator() : RequestHandlerLocator
    {
        return new RequestHandlerLocator(
            $this->createGetRequestHandler(),
            $this->createPostRequestHandler()
        );
    }

    /**
     * @return StateDataService
     */
    public function createApplicationState()
    {
        return new StateDataService(
            $this->createStateDataLoader($this->stateDataDirectory),
            $this->createStateDataWriter($this->stateDataDirectory)
        );
    }

    /**
     * @return GetRequestHandler
     */
    private function createGetRequestHandler()
    {
        return new GetRequestHandler($this->createGetRouteChain());
    }

    /**
     * @return PostRequestHandler
     */
    private function createPostRequestHandler()
    {
        return new PostRequestHandler($this->createPostRouteChain());
    }

    /**
     * @param $stateDataDirectory
     *
     * @return StateDataFileLoader
     */
    private function createStateDataLoader($stateDataDirectory)
    {
        return new StateDataFileLoader($stateDataDirectory);
    }

    /**
     * @param $stateDataDirectory
     *
     * @return StateDataFileWriter
     */
    private function createStateDataWriter($stateDataDirectory)
    {
        return new StateDataFileWriter($stateDataDirectory);
    }
}