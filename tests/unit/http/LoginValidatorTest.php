<?php

namespace Kartenmacherei\HttpFramework\Http;

use Kartenmacherei\HttpFramework\ManagedServices\ErrorCollection;
use PHPUnit_Framework_MockObject_MockObject;
use PHPUnit_Framework_TestCase;

/**
 * @uses \Kartenmacherei\HttpFramework\ManagedServices\ErrorCollection
 * @uses \Kartenmacherei\HttpFramework\ManagedServices\Error
 * @uses \Kartenmacherei\HttpFramework\Http\FailedValidationResult
 * @uses \Kartenmacherei\HttpFramework\Http\SuccessfulValidationResult
 *
 * @covers \Kartenmacherei\HttpFramework\Http\LoginValidator
 */
class LoginValidatorTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var LoginValidator
     */
    private $loginValidator;

    /**
     * @var PostRequest | PHPUnit_Framework_MockObject_MockObject
     */
    private $mockRequest;

    /**
     * @var ErrorCollection | PHPUnit_Framework_MockObject_MockObject
     */
    private $mockErrorCollection;

    protected function setup()
    {
        $this->mockRequest = $this->getMockBuilder(PostRequest::class)->disableOriginalConstructor()->getMock();

        $this->mockErrorCollection = $this->getMockBuilder(ErrorCollection::class)->disableOriginalConstructor()->getMock();

        $this->loginValidator = new LoginValidator($this->mockRequest, $this->mockErrorCollection);
    }

    public function testCanGetSuccessfulResultObjectFromValidation()
    {
        $this->mockRequest->method('hasParameter')->willReturn(true);

        $this->assertInstanceOf(SuccessfulValidationResult::class, $this->loginValidator->validate());
    }

    public function testCanGetErrors()
    {
        $this->assertInstanceOf(ErrorCollection::class, $this->loginValidator->getErrors());
    }

    public function testCanGetFailedResultObjectFromValidation()
    {
        $this->mockRequest->method('hasParameter')->willReturn(false);
        $this->mockErrorCollection->method('count')->willReturn(2);

        $this->assertInstanceOf(FailedValidationResult::class, $this->loginValidator->validate());
    }
}