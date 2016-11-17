<?php

namespace Kartenmacherei\HttpFramework\Http;

use Kartenmacherei\HttpFramework\ManagedServices\ErrorCollection;
use PHPUnit_Framework_MockObject_MockObject;
use PHPUnit_Framework_TestCase;

/**
 * @uses \Kartenmacherei\HttpFramework\Http\SuccessfulValidationResult
 * @uses \Kartenmacherei\HttpFramework\Http\FailedValidationResult
 * @uses \Kartenmacherei\HttpFramework\ManagedServices\ErrorCollection
 * @uses \Kartenmacherei\HttpFramework\ManagedServices\Error
 * @uses \Kartenmacherei\HttpFramework\Library\AbstractCollection
 *
 * @covers \Kartenmacherei\HttpFramework\Http\CreateProjectValidator
 */
class CreateProjectValidatorTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var PostRequest | PHPUnit_Framework_MockObject_MockObject
     */
    private $mockPostRequest;

    /**
     * @var CreateProjectValidator | PHPUnit_Framework_MockObject_MockObject
     */
    private $createProjectValidator;

    /**
     * @var ErrorCollection | PHPUnit_Framework_MockObject_MockObject
     */
    private $errorCollectionMock;

    protected function setup()
    {
        $this->mockPostRequest = $this->getMockBuilder(PostRequest::class)->disableOriginalConstructor()->getMock();
        $this->errorCollectionMock = $this->getMockBuilder(ErrorCollection::class)->disableOriginalConstructor()->getMock();

        $this->createProjectValidator = new CreateProjectValidator($this->mockPostRequest, $this->errorCollectionMock);
    }

    public function testCanGetErrors()
    {
        $this->errorCollectionMock->method('count')->willReturn(2);
        $this->assertInstanceOf(ErrorCollection::class, $this->createProjectValidator->getErrors());
    }

    public function testValidateWithProjectTitleAndValueReturnsSuccessfulValidationObject()
    {
        $this->mockPostRequest->method('hasParameter')->willReturn(true);
        $this->mockPostRequest->method('getValueByName')->willReturn('projectTitle');
        $this->errorCollectionMock->method('count')->willReturn(0);

        $this->assertInstanceOf(SuccessfulValidationResult::class, $this->createProjectValidator->validate());
    }

    public function testValidateWithoutProjectTitleOrValueReturnsFailedValidationObject()
    {
        $this->mockPostRequest->method('hasParameter')->willReturn(false);
        $this->errorCollectionMock->method('add')->willReturn(true);
        $this->errorCollectionMock->method('count')->willReturn(2);

        $this->assertInstanceOf(FailedValidationResult::class, $this->createProjectValidator->validate());
    }
}