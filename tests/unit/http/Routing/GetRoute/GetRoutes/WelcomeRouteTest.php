<?php

namespace Kartenmacherei\HttpFramework\Query;

use Kartenmacherei\HttpFramework\StateDataService;
use Kartenmacherei\HttpFramework\ApplicationStateFacade;
use Kartenmacherei\HttpFramework\Factory;

use Kartenmacherei\HttpFramework\Http\GetRequest;
use Kartenmacherei\HttpFramework\Http\Path;

use Kartenmacherei\HttpFramework\Library\RoutingException;
use PHPUnit_Framework_MockObject_MockObject;

/**
 * @uses   \Kartenmacherei\HttpFramework\Http\Path
 * @uses   \Kartenmacherei\HttpFramework\Query\NotFoundQuery
 * @uses   \Kartenmacherei\HttpFramework\Query\NotFoundRoute
 * @uses   \Kartenmacherei\HttpFramework\Query\WelcomeRoute
 *
 * @covers \Kartenmacherei\HttpFramework\Http\GetRoute
 * @covers \Kartenmacherei\HttpFramework\Query\WelcomeRoute
 */
class WelcomeRouteTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var GetRequest | PHPUnit_Framework_MockObject_MockObject
     */
    private $noMatchRequestMock;

    /**
     * @var WelcomeRoute
     */
    private $welcomeRoute;

    /**
     * @var StateDataService | PHPUnit_Framework_MockObject_MockObject
     */
    private $applicationStateMock;

    protected function setUp()
    {
        /**
         * @var GetRequest | PHPUnit_Framework_MockObject_MockObject $noMatchRequestMock
         */
        $this->noMatchRequestMock = $this->getMockBuilder(GetRequest::class)
                                         ->disableOriginalConstructor()
                                         ->getMock();
        $this->noMatchRequestMock->method('getPath')
                                 ->willReturn(new Path('/noMatch'));

        $welcomeQuery = $this->getMockBuilder(WelcomeQuery::class)
                             ->disableOriginalConstructor()
                             ->getMock();
        /** @var ApplicationStateFacade | PHPUnit_Framework_MockObject_MockObject applicationStateFacadeMock */
        $this->applicationStateMock = $this->getMockBuilder(StateDataService::class)
                                           ->disableOriginalConstructor()
                                           ->getMock();
        $this->applicationStateMock->method('isLoggedIn')->willReturn(true);

        /**
         * @var Factory | PHPUnit_Framework_MockObject_MockObject $FactoryMock
         */
        $FactoryMock = $this->getMockBuilder(Factory::class)
                            ->disableOriginalConstructor()
                            ->getMock();
        $FactoryMock->method('createWelcomeQuery')
                    ->willReturn($welcomeQuery);

        $this->welcomeRoute = new WelcomeRoute($FactoryMock, $this->applicationStateMock);
    }

    public function testCanRouteToWelcomeQuery()
    {
        $pathStringMock = '/welcome';

        /**
         * @var GetRequest | PHPUnit_Framework_MockObject_MockObject $requestMock
         */
        $requestMock = $this->getMockBuilder(GetRequest::class)
                            ->disableOriginalConstructor()
                            ->getMock();
        $requestMock->method('getPath')
                    ->willReturn(new Path($pathStringMock));

        $welcomeQuery = $this->welcomeRoute->route($requestMock);

        $this->assertInstanceOf(WelcomeQuery::class, $welcomeQuery);
    }

    public function testCanIndicateWhenNoDefaultRoutesExistsWhenNoRoutesMatch()
    {
        $this->expectException(RoutingException::class);

        $this->welcomeRoute->route($this->noMatchRequestMock);
    }

    public function testCanRouteToNextRouteIfFirstRouteDoesNotMatch()
    {
        /**
         * @var NotFoundRoute | PHPUnit_Framework_MockObject_MockObject $notFoundRouteMock
         */
        $notFoundRouteMock = $this->getMockBuilder(NotFoundRoute::class)
                                  ->getMock();

        $this->welcomeRoute->setNext($notFoundRouteMock);

        $returnedQuery = $this->welcomeRoute->route($this->noMatchRequestMock);

        $this->assertInstanceOf(NotFoundQuery::class, $returnedQuery);
    }
}
