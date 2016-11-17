<?php

namespace Kartenmacherei\HttpFramework\Http;

use Kartenmacherei\HttpFramework\StateDataService;
use Kartenmacherei\HttpFramework\Command\LoginCommand;
use Kartenmacherei\HttpFramework\Command\ProcessLoginRoute;
use Kartenmacherei\HttpFramework\Factory;
use Kartenmacherei\HttpFramework\Library\RoutingException;
use PHPUnit_Framework_MockObject_MockObject;
use stdClass;

/**
 * @uses   \Kartenmacherei\HttpFramework\Http\Path
 * @uses   \Kartenmacherei\HttpFramework\Http\PostRoute
 * @uses   \Kartenmacherei\HttpFramework\Command\ProcessLoginRoute
 *
 * @covers \Kartenmacherei\HttpFramework\Http\PostRouteChain
 */
class PostRouterTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var PostRouteChain
     */
    private $postRouter;

    /**
     * @var LoginCommand | PHPUnit_Framework_MockObject_MockObject
     */
    private $loginCommandMock;

    /**
     * @var PostRoute | PHPUnit_Framework_MockObject_MockObject
     */
    private $processLoginRouteMock;

    /**
     * @var PostRequest
     */
    private $loginRequestMock;

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

        $this->loginCommandMock = $this->getMockBuilder(LoginCommand::class)
                                       ->disableOriginalConstructor()
                                       ->getMock();

        $this->FactoryMock = $this->getMockBuilder(Factory::class)
                                  ->disableOriginalConstructor()
                                  ->getMock();
        $this->FactoryMock->method('createLoginCommand')
                          ->willReturn($this->loginCommandMock);

        $this->processLoginRouteMock = $this->getMockBuilder(ProcessLoginRoute::class)
                                            ->setConstructorArgs(
                                                [$this->FactoryMock, $this->applicationStateMock]
                                            )
                                            ->getMock();

        $this->loginRequestMock = $this->getMockBuilder(PostRequest::class)
                                       ->disableOriginalConstructor()
                                       ->getMock();
        $this->loginRequestMock->method('getPath')
                               ->willReturn(new Path('/login'));

        $this->postRouter = new PostRouteChain();
    }

    public function testCanAddRoute()
    {
        $this->postRouter->add($this->processLoginRouteMock);

        $returnedCommandMock = $this->postRouter->route($this->loginRequestMock);

        $this->assertEquals($this->loginCommandMock, $returnedCommandMock);
    }

    public function testCanAddNextRoute()
    {
        $this->postRouter->add($this->processLoginRouteMock);
        $this->postRouter->add($this->processLoginRouteMock);

        $returnedCommand = $this->postRouter->route($this->loginRequestMock);

        $this->assertEquals($this->loginCommandMock, $returnedCommand);
    }

    public function testCanNotAddInvalidRoute()
    {
        $this->expectException(RoutingException::class);
        $this->expectExceptionMessage('Route did not return a Command object');

        $FactoryMock = $this->getMockBuilder(Factory::class)
                            ->disableOriginalConstructor()
                            ->getMock();
        $FactoryMock->method('createLoginCommand')
                    ->willReturn(new StdClass);
        /**
         * @var PostRoute | PHPUnit_Framework_MockObject_MockObject $routeMock
         */
        $routeMock = $this->getMockBuilder(ProcessLoginRoute::class)
                          ->setConstructorArgs([$FactoryMock, $this->applicationStateMock])
                          ->getMock();

        $this->postRouter->add($routeMock);
        $this->postRouter->route($this->loginRequestMock);
    }
}
