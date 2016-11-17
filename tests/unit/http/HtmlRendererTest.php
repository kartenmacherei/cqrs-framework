<?php

namespace Kartenmacherei\HttpFramework;

/**
 * @uses   Kartenmacherei\HttpFramework\File
 *
 * @covers \Kartenmacherei\HttpFramework\HtmlRenderer
 */
class HtmlRendererTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var TestViewModel
     */
    private $testViewModel;

    /**
     * @var HtmlRenderer
     */
    private $renderer;

    /**
     * @var Directory | \PHPUnit_Framework_MockObject_MockObject
     */
    private $directoryMock;

    protected function setUp()
    {
        $this->testViewModel = new TestViewModel();

        $this->directoryMock = $this->getMockBuilder(Directory::class)
                                    ->disableOriginalConstructor()
                                    ->getMock();
        $this->directoryMock->method('__toString')->willReturn(__DIR__ . '/../../testFiles/');

        $this->renderer = new HtmlRenderer($this->directoryMock);
    }

    public function testCanProperlyRenderTemplateWithViewModel()
    {
        $expectedRenderedContent = "<div property='hello'>goodbye</div>";

        $this->assertEquals(
            $expectedRenderedContent,
            $this->renderer->render("<div property='hello'></div>", $this->testViewModel)
        );
    }
}
