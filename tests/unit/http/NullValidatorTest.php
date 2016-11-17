<?php

namespace Kartenmacherei\HttpFramework\Http;

use PHPUnit_Framework_TestCase;

/**
 * @uses \Kartenmacherei\HttpFramework\Http\SuccessfulValidationResult
 *
 * @covers \Kartenmacherei\HttpFramework\Http\NullValidator
 */
class NullValidatorTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var NullValidator
     */
    private $nullValidator;

    /**
     * @var GetRequest | \PHPUnit_Framework_MockObject_MockObject
     */
    private $mockGetRequest;

    protected function setup()
    {
        $this->mockGetRequest = $this->getMockBuilder(GetRequest::class)->disableOriginalConstructor()->getMock();
        $this->nullValidator  = new NullValidator($this->mockGetRequest);
    }

    public function testValidateReturnsSuccessfulValidationResult()
    {
        $this->assertInstanceOf(SuccessfulValidationResult::class, $this->nullValidator->validate());
    }
}