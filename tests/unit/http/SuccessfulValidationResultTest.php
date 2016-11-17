<?php

namespace Kartenmacherei\HttpFramework\Http;

use Kartenmacherei\HttpFramework\ManagedServices\ErrorCollection;
use PHPUnit_Framework_MockObject_MockObject;
use PHPUnit_Framework_TestCase;

/**
 *
 * @covers \Kartenmacherei\HttpFramework\Http\SuccessfulValidationResult
 */
class SuccessfulValidationResultTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var ErrorCollection | PHPUnit_Framework_MockObject_MockObject
     */
    private $mockErrorCollection;

    /**
     * @var GetRequest | PHPUnit_Framework_MockObject_MockObject
     */
    private $mockRequest;

    /**
     * @var FailedValidationResult
     */
    private $validationResult;

    /**
     * @var Path | PHPUnit_Framework_MockObject_MockObject
     */
    private $mockPath;

    protected function setup()
    {
        $this->mockRequest = $this->getMockBuilder(GetRequest::class)->disableOriginalConstructor()->getMock();
        $this->mockErrorCollection = $this->getMockBuilder(ErrorCollection::class)->disableOriginalConstructor()->getMock();
        $this->mockPath = $this->getMockBuilder(Path::class)->disableOriginalConstructor()->getMock();
        $this->validationResult = new SuccessfulValidationResult($this->mockRequest, $this->mockErrorCollection);
    }

    public function testCanGetPathAsString()
    {
        $this->mockRequest->method('getPath')->willReturn($this->mockPath);
        $this->mockPath->method('asString')->willReturn('/login');
        $this->assertEquals('/login', $this->validationResult->path());
    }

    public function testIsSuccessReturnsTrue()
    {
        $this->assertTrue($this->validationResult->isSuccess());
    }

    public function testIsFailureReturnsFalse()
    {
        $this->assertFalse($this->validationResult->isFailure());
    }
}