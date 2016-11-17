<?php
namespace Kartenmacherei\CQRSFramework\Http;

/**
 * @covers \Kartenmacherei\CQRSFramework\Http\Path
 */
class PathTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Path
     */
    protected $path;

    protected function setUp()
    {
        $this->path = new Path('somePath');
    }

    public function testGetPath()
    {
        $this->assertEquals('somePath', $this->path->asString());
    }

    public function testPathEquality()
    {
        $path = new Path('/');
        $this->assertTrue($path->equals($path));
    }
}
