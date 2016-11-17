<?php

namespace Kartenmacherei\HttpFramework\Query;

use Kartenmacherei\HttpFramework\Http\GetRequest;
use PHPUnit_Framework_MockObject_MockObject;

/**
 * @covers \Kartenmacherei\HttpFramework\Http\GetRoute
 * @covers \Kartenmacherei\HttpFramework\Query\NotFoundRoute
 */
class NotFoundRouteTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var GetRequest | PHPUnit_Framework_MockObject_MockObject
     */
    private $getRequestMock;

    /**
     * @var NotFoundRoute
     */
    private $notFoundRoute;

    public function setUp()
    {
        $this->getRequestMock = $this->getMockBuilder(GetRequest::class)
                               ->disableOriginalConstructor()
                               ->getMock();

        $this->notFoundRoute = new NotFoundRoute();
    }

    public function testCanRouteToNotFoundQuery()
    {
        $notFoundQuery = $this->notFoundRoute->route($this->getRequestMock);

        $this->assertInstanceOf(NotFoundQuery::class, $notFoundQuery);
    }
}
