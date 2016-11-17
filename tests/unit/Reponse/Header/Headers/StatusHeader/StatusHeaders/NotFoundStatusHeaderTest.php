<?php

namespace Kartenmacherei\CQRSFramework\Http;

/**
 * @covers \Kartenmacherei\CQRSFramework\Http\NotFoundStatusHeader
 */
class NotFoundStatusHeaderTest extends \PHPUnit_Framework_TestCase
{
    public function testCanSendStatusHeader()
    {
        $statusHeader = new NotFoundStatusHeader();

        $statusHeader->send();

        $mockedHeaders = HeaderTestHelper::getText();

        $this->assertEquals('HTTP/1.1 404 Not Found', $mockedHeaders);
    }
}
