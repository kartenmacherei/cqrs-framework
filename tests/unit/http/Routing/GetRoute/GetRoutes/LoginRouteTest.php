<?php

namespace Kartenmacherei\HttpFramework\Query;

use Kartenmacherei\HttpFramework\Factory;
use Kartenmacherei\HttpFramework\Http\GetRequest;
use Kartenmacherei\HttpFramework\Http\Path;
use Kartenmacherei\HttpFramework\LoggedOutPostState;
use PHPUnit_Framework_MockObject_MockObject;

/**
 * @uses   \Kartenmacherei\HttpFramework\Http\Path
 * @uses   \Kartenmacherei\HttpFramework\Http\GetRoute
 *
 * @covers \Kartenmacherei\HttpFramework\Query\LoginRoute
 */
class LoginRouteTest extends \PHPUnit_Framework_TestCase
{
    public function testCanRetrieveLoginQueryFromRoute()
    {
        /**
         * @var LoginQuery | PHPUnit_Framework_MockObject_MockObject $loginQueryMock
         */
        $loginQueryMock = $this->getMockBuilder(LoginQuery::class)
                               ->disableOriginalConstructor()
                               ->getMock();

        /**
         * @var Factory | PHPUnit_Framework_MockObject_MockObject $FactoryMock
         */
        $FactoryMock = $this->getMockBuilder(Factory::class)
                            ->disableOriginalConstructor()
                            ->getMock();
        $FactoryMock->method('createLoginQuery')
                    ->willReturn($loginQueryMock);

        /**
         * @var GetRequest | PHPUnit_Framework_MockObject_MockObject $loginRequestMock
         */
        $loginRequestMock = $this->getMockBuilder(GetRequest::class)
                                 ->disableOriginalConstructor()
                                 ->getMock();
        $loginRequestMock->method('getPath')
                         ->willReturn(new Path('/login'));

        /**
         * @var LoggedOutPostState | PHPUnit_Framework_MockObject_MockObject $applicationStateMock
         */
        $applicationStateMock = $this->getMockBuilder(LoggedOutPostState::class)
                                     ->disableOriginalConstructor()
                                     ->getMock();

        $loginRoute = new LoginRoute($FactoryMock, $applicationStateMock);

        $queryUnderTest = $loginRoute->route($loginRequestMock);

        $this->assertEquals($loginQueryMock, $queryUnderTest);
    }
}
