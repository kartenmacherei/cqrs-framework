<?php

namespace Kartenmacherei\CQRSFramework\Http;

use Kartenmacherei\CQRSFramework\StateDataService;
use Kartenmacherei\CQRSFramework\Factory;
use Kartenmacherei\CQRSFramework\Library\RoutingException;
use Kartenmacherei\CQRSFramework\Query\WelcomeQuery;
use Kartenmacherei\CQRSFramework\Query\WelcomeRoute;
use PHPUnit_Framework_MockObject_MockObject;
use stdClass;

/**
 * @uses   \Kartenmacherei\CQRSFramework\Http\GetRoute
 * @uses   \Kartenmacherei\CQRSFramework\Http\Path
 * @uses   \Kartenmacherei\CQRSFramework\Query\WelcomeRoute
 * @uses   \Kartenmacherei\CQRSFramework\Http\Request
 *
 * @covers \Kartenmacherei\CQRSFramework\Http\GetRouteChain
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
