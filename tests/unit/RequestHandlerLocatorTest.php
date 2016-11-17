<?php

namespace Kartenmacherei\HttpFramework\Http;

use Kartenmacherei\HttpFramework\ApplicationController;
use Kartenmacherei\HttpFramework\StateDataService;
use Kartenmacherei\HttpFramework\Factory;
use PHPUnit_Framework_MockObject_MockObject;
use PHPUnit_Framework_TestCase;

/**
 * @uses   \Kartenmacherei\HttpFramework\Http\Path
 * @uses   \Kartenmacherei\HttpFramework\Http\Request
 * @uses   \Kartenmacherei\HttpFramework\Http\PostRequest
 * @uses   \Kartenmacherei\HttpFramework\Http\PostRequestHandler
 * @uses   \Kartenmacherei\HttpFramework\Http\GetRequest
 * @uses   \Kartenmacherei\HttpFramework\Http\GetRequestHandler
 *
 * @covers \Kartenmacherei\HttpFramework\Http\RequestHandlerLocator
 */
class RequestHandlerLocatorTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var StateDataService | PHPUnit_Framework_MockObject_MockObject
     */
    private $mockAppState;

    /**
     * @var Factory | PHPUnit_Framework_MockObject_MockObject
     */
    private $mockFactory;

    /**
     * @var ApplicationController | \PHPUnit_Framework_MockObject_MockObject
     */
    private $mockAppController;

    /**
     * @var RequestHandlerLocator | PHPUnit_Framework_MockObject_MockObject
     */
    private $locator;

    /**
     * @var PostRequest
     */
    private $postRequest;

    /**
     * @var GetRequest
     */
    private $getRequest;

    /**
     * @var GetRequestHandler | PHPUnit_Framework_MockObject_MockObject
     */
    private $mockGetRequestHandler;

    /**
     * @var PostRequestHandler | PHPUnit_Framework_MockObject_MockObject
     */
    private $mockPostRequestHandler;

    protected function setup()
    {

        $this->mockAppState      = $this->getMockBuilder(StateDataService::class)
                                        ->disableOriginalConstructor()
                                        ->getMock();
        $this->mockFactory       = $this->getMockBuilder(Factory::class)->disableOriginalConstructor()->getMock();
        $this->mockAppController = $this->getMockBuilder(ApplicationController::class)
                                        ->disableOriginalConstructor()
                                        ->getMock();

        $this->mockGetRequestHandler  = $this->getMockBuilder(GetRequestHandler::class)
                                             ->disableOriginalConstructor()
                                             ->getMock();
        $this->mockPostRequestHandler = $this->getMockBuilder(PostRequestHandler::class)
                                             ->disableOriginalConstructor()
                                             ->getMock();

        $this->postRequest = new PostRequest(new Path(''), new ParameterCollection(), new ParameterCollection());
        $this->getRequest  = new GetRequest(new Path(''), new ParameterCollection(), new ParameterCollection());

        $this->locator = new RequestHandlerLocator($this->mockFactory, $this->mockAppState, $this->mockAppController);
    }

    public function testCanGetCorrectGetHandler()
    {
        $this->mockFactory->method('createGetRequestHandler')->willReturn($this->mockGetRequestHandler);
        $this->assertInstanceOf(GetRequestHandler::class, $this->locator->locateHandler($this->getRequest));
    }

    public function testCanGetCorrectPostHandler()
    {
        $this->mockFactory->method('createPostRequestHandler')->willReturn($this->mockPostRequestHandler);
        $this->assertInstanceOf(PostRequestHandler::class, $this->locator->locateHandler($this->postRequest));
    }
}