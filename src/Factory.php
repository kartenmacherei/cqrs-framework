<?php

namespace Kartenmacherei\CQRSFramework;

use Kartenmacherei\CQRSFramework\ApplicationState\StateDataFileLoader;
use Kartenmacherei\CQRSFramework\ApplicationState\StateDataFileWriter;
use Kartenmacherei\CQRSFramework\ApplicationState\StateDataService;
use Kartenmacherei\CQRSFramework\Library\File\Directory;
use Kartenmacherei\CQRSFramework\Routing\GetRequestHandler;
use Kartenmacherei\CQRSFramework\Routing\GetRoute\GetRouteChain;
use Kartenmacherei\CQRSFramework\Routing\PostRequestHandler;
use Kartenmacherei\CQRSFramework\Routing\PostRoute\PostRouteChain;
use Kartenmacherei\CQRSFramework\Routing\RequestHandlerLocator;

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