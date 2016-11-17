<?php

namespace Kartenmacherei\HttpFramework\Http;

/**
 * @covers \Kartenmacherei\HttpFramework\Http\TemporaryRedirectHeader
 */
class TemporaryRedirectHeaderTest extends \PHPUnit_Framework_TestCase
{
    public function testCanSendRedirectHeader()
    {
        $pathMockString = '/testPath';
        $expectedResponseCode = 302;

        /**
         * @var Path | \PHPUnit_Framework_MockObject_MockObject $pathMock
         */
        $pathMock = $this->getMockBuilder(Path::class)
                         ->disableOriginalConstructor()
                         ->getMock();
        $pathMock->method('asString')
                 ->willReturn($pathMockString);

        $redirectHeader = new TemporaryRedirectHeader($pathMock);
        $redirectHeader->send();

        $expectedHeader = 'Location: ' . $pathMockString;

        $headerMock = HeaderTestHelper::getText();
        $mockedResponseCode = HeaderTestHelper::getCode();

        $this->assertEquals($expectedHeader, $headerMock);
        $this->assertEquals($expectedResponseCode, $mockedResponseCode);
    }
}
