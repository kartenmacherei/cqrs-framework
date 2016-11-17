<?php

namespace Kartenmacherei\HttpFramework\Http;

use Kartenmacherei\HttpFramework\StateDataService;
use Kartenmacherei\HttpFramework\Factory;
use Kartenmacherei\HttpFramework\Library\RoutingException;
use Kartenmacherei\HttpFramework\Query\WelcomeQuery;
use Kartenmacherei\HttpFramework\Query\WelcomeRoute;
use PHPUnit_Framework_MockObject_MockObject;
use stdClass;

/**
 * @uses   \Kartenmacherei\HttpFramework\Http\GetRoute
 * @uses   \Kartenmacherei\HttpFramework\Http\Path
 * @uses   \Kartenmacherei\HttpFramework\Query\WelcomeRoute
 * @uses   \Kartenmacherei\HttpFramework\Http\Request
 *
 * @covers \Kartenmacherei\HttpFramework\Http\GetRouteChain
 */
class GetRouterTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var GetRouteChain
     */
    private $getRouter;

    /**
     * @var WelcomeQuery | PHPUnit_Framework_MockObject_MockObject
     */
    private $welcomeQueryMock;

    /**
     * @var WelcomeRoute | PHPUnit_Framework_MockObject_MockObject
     */
    private $welcomeRouteMock;

    /**
     * @var GetRequest | PHPUnit_Framework_MockObject_MockObject
     */
    private $welcomeRequestMock;

    /**
     * @var Factory | PHPUnit_Framework_MockObject_MockObject
     */
    private $FactoryMock;

    /**
     * @var StateDataService | PHPUnit_Framework_MockObject_MockObject
     */
    private $applicationStateMock;

    public function setUp()
    {
        $this->applicationStateMock = $this->getMockBuilder(StateDataService::class)
                                           ->disableOriginalConstructor()
                                           ->getMock();
        $this->applicationStateMock->method('isLoggedIn')->willReturn(true);

        $this->welcomeQueryMock = $this->getMockBuilder(WelcomeQuery::class)
                                       ->disableOriginalConstructor()
                                       ->getMock();

        $this->FactoryMock = $this->getMockBuilder(Factory::class)
                                  ->disableOriginalConstructor()
                                  ->getMock();
        $this->FactoryMock->method('createWelcomeQuery')
                          ->willReturn($this->welcomeQueryMock);

        $this->welcomeRouteMock = $this->getMockBuilder(WelcomeRoute::class)
                                       ->setConstructorArgs([$this->FactoryMock, $this->applicationStateMock])
                                       ->getMock();

        $this->welcomeRequestMock = $this->getMockBuilder(GetRequest::class)
                                         ->disableOriginalConstructor()
                                         ->getMock();
        $this->welcomeRequestMock->method('getPath')
                                 ->willReturn(new Path('/welcome'));

        $this->getRouter = new GetRouteChain();
    }

    public function testCanAddRoute()
    {
        $this->getRouter->add($this->welcomeRouteMock);

        $returnedQueryMock = $this->getRouter->route($this->welcomeRequestMock);

        $this->assertEquals($this->welcomeQueryMock, $returnedQueryMock);
    }

    public function testCanAddNextRoute()
    {
        $this->getRouter->add($this->welcomeRouteMock);
        $this->getRouter->add($this->welcomeRouteMock);

        $returnedQuery = $this->getRouter->route($this->welcomeRequestMock);

        $this->assertEquals($this->welcomeQueryMock, $returnedQuery);
    }

    public function testCanNotAddInvalidRoute()
    {
        $FactoryMock = $this->getMockBuilder(Factory::class)
                            ->disableOriginalConstructor()
                            ->getMock();
        $FactoryMock->method('createWelcomeQuery')
                    ->willReturn(new StdClass);
        /**
         * @var WelcomeRoute | PHPUnit_Framework_MockObject_MockObject $routeMock
         */
        $routeMock = $this->getMockBuilder(WelcomeRoute::class)
                          ->setConstructorArgs([$FactoryMock, $this->applicationStateMock])
                          ->getMock();

        $this->getRouter->add($routeMock);

        $this->expectException(RoutingException::class);
        $this->expectExceptionMessage('Route did not return a Query object');

        $this->getRouter->route($this->welcomeRequestMock);
    }
}
