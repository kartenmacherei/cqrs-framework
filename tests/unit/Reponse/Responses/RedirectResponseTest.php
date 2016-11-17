<?php

namespace Kartenmacherei\HttpFramework\Http;

class RedirectResponseTest extends \PHPUnit_Framework_TestCase
{
    public function testCanSendRedirectResponseHeader()
    {
        $pathMockString = '/testPath';
        $expectedHeader = 'Location: ' . $pathMockString;
        $expectedResponseCode = 302;

        /**
         * @var Path | \PHPUnit_Framework_MockObject_MockObject $pathMock
         */
        $pathMock = $this->getMockBuilder(Path::class)
                         ->disableOriginalConstructor()
                         ->getMock();
        $pathMock->method('asString')
                 ->willReturn($pathMockString);

        $redirectResponse = new RedirectResponse($pathMock);
        $redirectResponse->send();

        $headerMock = HeaderTestHelper::getText();
        $responseCodeMock = HeaderTestHelper::getCode();

        $this->assertEquals($expectedHeader, $headerMock);
        $this->assertEquals($expectedResponseCode, $responseCodeMock);
    }
}
