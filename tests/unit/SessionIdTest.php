<?php

namespace Kartenmacherei\HttpFramework\Http;

/**
 * @covers \Kartenmacherei\HttpFramework\Http\SessionId
 */
class SessionIdTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var SessionId
     */
    private $sessionId;

    /**
     * @var string
     */
    private $sessionIdString;

    /**
     * @var int
     */
    private $generatedSessionIdStringLength;

    protected function setUp()
    {
        $this->sessionIdString                = 'string';
        $this->generatedSessionIdStringLength = 40;

        $this->sessionId = new SessionId($this->sessionIdString);
    }

    public function testCanCreateIdentifierForNullIdString()
    {
        $sessionId = new SessionId();

        $this->assertInstanceOf(SessionId::class, $sessionId);
        $this->assertEquals($this->generatedSessionIdStringLength, strlen($sessionId->asString()));
    }

    public function testCanBeRetrievedAsString()
    {
        $this->assertEquals($this->sessionIdString, $this->sessionId->asString());
    }

    public function testOriginalIdentifierCanBeRetrieved()
    {
        $this->assertEquals($this->sessionIdString, $this->sessionId->getOriginalId());
    }

    public function testCookieNameCanBeRetrieved()
    {
        $this->assertEquals('sId', $this->sessionId->getCookieName());
    }

    public function testCanBeCreatedFromRequestWithExistingCookie()
    {
        /**
         * @var Parameter | \PHPUnit_Framework_MockObject_MockObject $cookieMock
         */
        $cookieMock = $this->getMockBuilder(Parameter::class)
                           ->disableOriginalConstructor()
                           ->getMock();
        $cookieMock->method('getValue')->willReturn($this->sessionIdString);

        /**
         * @var Request | \PHPUnit_Framework_MockObject_MockObject $requestMock
         */
        $requestMock = $this->getMockBuilder(Request::class)
                            ->disableOriginalConstructor()
                            ->getMock();
        $requestMock->method('hasCookie')->willReturn(true);
        $requestMock->method('getCookieByName')->willReturn($this->sessionIdString);

        $sessionId = SessionId::fromRequest($requestMock);

        $this->assertEquals($this->sessionIdString, $sessionId->asString());
    }

    public function testCanBeCreatedFromRequestWithNoExistingCookie()
    {

        /**
         * @var Request | \PHPUnit_Framework_MockObject_MockObject $requestMock
         */
        $requestMock = $this->getMockBuilder(Request::class)
                            ->disableOriginalConstructor()
                            ->getMock();
        $requestMock->method('hasCookie')->willReturn(false);

        $sessionId = SessionId::fromRequest($requestMock);

        $this->assertEquals($this->generatedSessionIdStringLength, strlen($sessionId->asString()));
    }

    public function testCanRegenerateIdentifier()
    {
        $this->sessionId->regenerate();

        $this->assertNotEquals($this->sessionIdString, $this->sessionId->asString());
        $this->assertEquals($this->sessionIdString, $this->sessionId->getOriginalId());
    }

    public function testCanBeConvertedToString()
    {
        $expectedString = $this->sessionIdString;

        $this->assertEquals($expectedString, (string) $this->sessionId);
    }
}
