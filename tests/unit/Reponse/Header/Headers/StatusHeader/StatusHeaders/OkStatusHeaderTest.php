<?php

namespace Kartenmacherei\CQRSFramework\Http;

/**
 * @covers \Kartenmacherei\CQRSFramework\Http\OkStatusHeader
 */
class OkStatusHeaderTest extends \PHPUnit_Framework_TestCase
{
    public function testCanSendStatusHeader()
    {
        $statusHeader = new OkStatusHeader();

        $statusHeader->send();

        $mockedHeaders = HeaderTestHelper::getText();

        $this->assertEquals('HTTP/1.1 200 OK', $mockedHeaders);
    }
}
