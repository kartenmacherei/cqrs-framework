<?php

namespace Kartenmacherei\HttpFramework\Http;

use PHPUnit_Framework_MockObject_MockObject;

/**
 * @covers \Kartenmacherei\HttpFramework\Http\AbstractResponse
 * @covers \Kartenmacherei\HttpFramework\Http\ContentResponse
 */
class ContentResponseTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var StatusHeader | PHPUnit_Framework_MockObject_MockObject
     */
    private $statusHeaderMock;

    /**
     * @var Content | PHPUnit_Framework_MockObject_MockObject
     */
    private $contentMock;

    /**
     * @var ContentResponse
     */
    private $contentResponse;

    protected function setUp()
    {
        $this->statusHeaderMock = $this->getMockBuilder(StatusHeader::class)
                                       ->disableOriginalConstructor()
                                       ->getMock();

        $this->contentMock = $this->getMockBuilder(Content::class)
                                  ->disableOriginalConstructor()
                                  ->getMock();

        $this->contentResponse = new ContentResponse($this->statusHeaderMock, $this->contentMock);
    }

    public function testCanSendHeader()
    {
        $this->statusHeaderMock->expects($this->once())
                               ->method('send');

        $this->contentMock->expects($this->once())
                          ->method('send');

        $this->contentResponse->send();
    }

    public function testCanRetrieveStatusHeader()
    {
        $statusHeader = $this->contentResponse->getStatusHeader();

        $this->assertEquals($this->statusHeaderMock, $statusHeader);
    }

    public function testCanRetrieveContent()
    {
        $content = $this->contentResponse->getContent();

        $this->assertEquals($this->contentMock, $content);
    }

    public function testCookieIsSetWithPredefinedSessionId()
    {
        $expectedCookieName = 'sId';
        $expectedIdString   = '123';

        /**
         * @var SessionId | PHPUnit_Framework_MockObject_MockObject $sessionIdMock
         */
        $sessionIdMock = $this->getMockBuilder(SessionId::class)
                              ->disableOriginalConstructor()
                              ->getMock();
        $sessionIdMock->method('getCookieName')->willReturn($expectedCookieName);
        $sessionIdMock->method('asString')->willReturn($expectedIdString);

        $this->contentResponse->setSessionId($sessionIdMock);

        $this->contentResponse->send();

        $cookieName = SetCookieTestHelper::getName();
        $idString   = SetCookieTestHelper::getValue();

        $this->assertEquals($expectedCookieName, $cookieName);
        $this->assertEquals($expectedIdString, $idString);
    }
}
