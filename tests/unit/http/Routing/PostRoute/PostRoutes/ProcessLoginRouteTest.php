<?php

namespace Kartenmacherei\HttpFramework\Command;

use Kartenmacherei\HttpFramework\StateDataService;
use Kartenmacherei\HttpFramework\Factory;
use Kartenmacherei\HttpFramework\Http\Path;
use Kartenmacherei\HttpFramework\Http\PostRequest;
use Kartenmacherei\HttpFramework\Library\RoutingException;
use PHPUnit_Framework_MockObject_MockObject;

/**
 * @uses   \Kartenmacherei\HttpFramework\Factory
 * @uses   \Kartenmacherei\HttpFramework\Http\Parameter
 * @uses   \Kartenmacherei\HttpFramework\Http\Path
 * @uses   \Kartenmacherei\HttpFramework\Http\Request
 * @uses   \Kartenmacherei\HttpFramework\Http\ActiveDirectoryAuthenticator
 * @uses   \Kartenmacherei\HttpFramework\Library\AbstractIdentifier
 * @uses   \Kartenmacherei\HttpFramework\Library\Collection
 * @uses   \Kartenmacherei\HttpFramework\Library\RoutingException
 * @uses   \Kartenmacherei\HttpFramework\Library\AbstractIdentifier
 *
 * @covers \Kartenmacherei\HttpFramework\Http\PostRoute
 * @covers \Kartenmacherei\HttpFramework\Command\ProcessLoginRoute
 */
class ProcessLoginRouteTest extends \PHPUnit_Framework_TestCase
{
    /** @var ProcessLoginRoute $processLoginRoute */
    private $processLoginRoute;

    /** @var StateDataService | PHPUnit_Framework_MockObject_MockObject applicationStateMock */
    private $applicationStateMock;

    /** @var Factory | PHPUnit_Framework_MockObject_MockObject factoryMock */
    private $factoryMock;

    /** @var LoginCommand | PHPUnit_Framework_MockObject_MockObject loginCommandMock */
    private $loginCommandMock;

    /** @var PostRequest | PHPUnit_Framework_MockObject_MockObject postRequestMock */
    private $postRequestMock;

    /** @var  Path $path */
    private $path;

    /** @var  Path $wrongpath */
    private $wrongpath;

    public function setUp()
    {
        $this->path      = new Path('/login');
        $this->wrongpath = new Path('WRONGPATH');

        $this->factoryMock = $this->getMockBuilder(Factory::class)
                                  ->disableOriginalConstructor()
                                  ->setMethods(['createLoginCommand', 'createActiveDirectoryAuthenticator'])
                                  ->getMock();

        $this->applicationStateMock = $this->getMockBuilder(StateDataService::class)
                                           ->disableOriginalConstructor()
                                           ->getMock();

        $this->postRequestMock = $this->getMockBuilder(PostRequest::class)
                                      ->disableOriginalConstructor()
                                      ->getMock();

        $this->loginCommandMock = $this->getMockBuilder(LoginCommand::class)
                                       ->disableOriginalConstructor()
                                       ->getMock();

        //$this->postRequestMock->method('hasParameter')->willReturn(true);

        $this->factoryMock->method('createLoginCommand')->willReturn($this->loginCommandMock);

        $this->processLoginRoute = new ProcessLoginRoute($this->factoryMock, $this->applicationStateMock);
    }

    public function testCanMatchLoginUrl()
    {
        //$this->postRequestMock->method('getParameterByName')->with()
        $this->postRequestMock->method('getPath')->willReturn($this->path);
        $loginCommand = $this->processLoginRoute->route($this->postRequestMock);
        $this->assertInstanceOf(LoginCommand::class, $loginCommand);
    }

    public function testWillNotMatchToOtherUrls()
    {
        $this->postRequestMock->method('getPath')->willReturn($this->wrongpath);
        /**
         * @throws RoutingException
         */
        $this->expectException(RoutingException::class);
        $loginCommand = $this->processLoginRoute->route($this->postRequestMock);
        $this->assertInstanceOf(LoginCommand::class, $loginCommand);
    }
}
