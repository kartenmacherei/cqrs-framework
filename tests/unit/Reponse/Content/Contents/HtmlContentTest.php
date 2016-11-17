<?php

namespace Kartenmacherei\HttpFramework\Http;

/**
 * @covers \Kartenmacherei\HttpFramework\Http\HtmlContent
 */
class HtmlContentTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var HtmlContent
     */
    private $htmlContent;

    /**
     * @var string
     */
    private $expectedHeader;

    /**
     * @var string
     */
    private $htmlMock;

    protected function setUp()
    {
        $this->htmlMock = '<b>Test</b>';
        $this->expectedHeader = 'Content-Type: text/html; charset=utf-8';

        $this->htmlContent = new HtmlContent($this->htmlMock);
    }

    public function testCanSendHtmlContentHeader()
    {
        $this->expectOutputString($this->htmlMock);

        $this->htmlContent->send();

        $mockedHeader = HeaderTestHelper::getText();

        $this->assertEquals($this->expectedHeader, $mockedHeader);
    }

    public function testCanOutputHtmlContent()
    {
        $this->expectOutputString($this->htmlMock);

        $this->htmlContent->send();
    }
}
