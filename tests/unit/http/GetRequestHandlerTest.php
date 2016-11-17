<?php

namespace Kartenmacherei\HttpFramework\Http;

use Kartenmacherei\HttpFramework\StateDataService;
use Kartenmacherei\HttpFramework\Query\ProjectViewQuery;
use PHPUnit_Framework_MockObject_MockObject;
use PHPUnit_Framework_TestCase;

/**
 * @uses   \Kartenmacherei\HttpFramework\Http\Path
 * @uses   \Kartenmacherei\HttpFramework\Http\Request
 * @uses   \Kartenmacherei\HttpFramework\Http\PostRequest
 * @uses   \Kartenmacherei\HttpFramework\Http\GetRequest
 *
 * @covers \Kartenmacherei\HttpFramework\Http\GetRequestHandler
 */
class GetRequestHandlerTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var StateDataService | PHPUnit_Framework_MockObject_MockObject
     */
    private $mockAppState;

    /**
     * @var GetRouteChain | PHPUnit_Framework_MockObject_MockObject
     */
    private $mockGetRouter;

    /**
     * @var GetRequestHandler | PHPUnit_Framework_MockObject_MockObject
     */
    private $getHandler;

    /**
     * @var GetRequest | PHPUnit_Framework_MockObject_MockObject
     */
    private $mockGetRequest;

    /**
     * @var ProjectViewQuery | PHPUnit_Framework_MockObject_MockObject
     */
    private $mockProjectViewQuery;

    /**
     * @var ContentResponse | PHPUnit_Framework_MockObject_MockObject
     */
    private $mockContentResponse;

    /**
     * @var SessionId | PHPUnit_Framework_MockObject_MockObject
     */
    private $mockSessionId;

    protected function setup()
    {
        $this->mockAppState = $this->getMockBuilder(StateDataService::class)->disableOriginalConstructor()->getMock();

        $this->mockGetRouter = $this->getMockBuilder(GetRouteChain::class)->disableOriginalConstructor()->getMock();

        $this->mockGetRequest = $this->getMockBuilder(GetRequest::class)->disableOriginalConstructor()->getMock();

        $this->mockProjectViewQuery = $this->getMockBuilder(ProjectViewQuery::class)
                                           ->disableOriginalConstructor()
                                           ->getMock();

        $this->mockContentResponse = $this->getMockBuilder(ContentResponse::class)
                                          ->disableOriginalConstructor()
                                          ->getMock();

        $this->mockSessionId = $this->getMockBuilder(SessionId::class)
                                    ->disableOriginalConstructor()
                                    ->getMock();

        $this->getHandler = new GetRequestHandler($this->mockAppState, $this->mockGetRouter);
    }

    public function testHandlerReturnsContentResponse()
    {
        $this->mockGetRouter->method('route')->willReturn($this->mockProjectViewQuery);
        $this->mockProjectViewQuery->method('execute')->willReturn($this->mockContentResponse);
        $this->mockAppState->method('getSessionId')->willReturn($this->mockSessionId);
        $this->mockContentResponse->method('setSessionId')->willReturn(null);

        $this->assertInstanceOf(ContentResponse::class, $this->getHandler->handle($this->mockGetRequest));
    }
}