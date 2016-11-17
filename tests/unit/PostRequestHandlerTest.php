<?php

namespace Kartenmacherei\CQRSFramework\Http;

use Kartenmacherei\CQRSFramework\ApplicationController;
use Kartenmacherei\CQRSFramework\StateDataService;
use Kartenmacherei\CQRSFramework\Command\CreateProjectCommand;
use Kartenmacherei\CQRSFramework\Command\CreateProjectSuccessResult;
use Kartenmacherei\CQRSFramework\Factory;
use Kartenmacherei\CQRSFramework\Query\ProjectViewQuery;
use PHPUnit_Framework_MockObject_MockObject;
use PHPUnit_Framework_TestCase;

/**
 * @uses   \Kartenmacherei\CQRSFramework\Http\Path
 * @uses   \Kartenmacherei\CQRSFramework\Http\Request
 * @uses   \Kartenmacherei\CQRSFramework\Http\PostRequest
 * @uses   \Kartenmacherei\CQRSFramework\Http\GetRequest
 * @uses   \Kartenmacherei\CQRSFramework\Http\GetRequestHandler
 *
 * @covers \Kartenmacherei\CQRSFramework\Http\PostRequestHandler
 */
class PostRequestHandlerTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var StateDataService | PHPUnit_Framework_MockObject_MockObject
     */
    private $mockAppState;

    /**
     * @var PostRouteChain | PHPUnit_Framework_MockObject_MockObject
     */
    private $mockPostRouter;

    /**
     * @var GetRequestHandler | PHPUnit_Framework_MockObject_MockObject
     */
    private $getHandler;

    /**
     * @var PostRequest | PHPUnit_Framework_MockObject_MockObject
     */
    private $mockPostRequest;

    /**
     * @var Factory | PHPUnit_Framework_MockObject_MockObject
     */
    private $mockFactory;

    /**
     * @var ProjectViewQuery | PHPUnit_Framework_MockObject_MockObject
     */
    private $mockProjectViewQuery;

    /**
     * @var ContentResponse | PHPUnit_Framework_MockObject_MockObject
     */
    private $mockContentResponse;

    /**
     * @var SessionId | PHPUnit_Framework_MockObject_MockObject
     */
    private $mockSessionId;

    /**
     * @var ApplicationController | PHPUnit_Framework_MockObject_MockObject
     */
    private $mockAppController;

    /**
     * @var CreateProjectValidator | PHPUnit_Framework_MockObject_MockObject
     */
    private $mockValidator;

    /**
     * @var SuccessfulValidationResult | PHPUnit_Framework_MockObject_MockObject
     */
    private $mockSuccessfulValidationResult;

    /**
     * @var RedirectResponse | PHPUnit_Framework_MockObject_MockObject
     */
    private $mockRedirectResponse;

    /**
     * @var CreateProjectCommand | PHPUnit_Framework_MockObject_MockObject
     */
    private $mockCreateProjectCommand;

    /**
     * @var CreateProjectSuccessResult | PHPUnit_Framework_MockObject_MockObject
     */
    private $mockCreateProjectSuccessResult;

    /**
     * @var FailedValidationResult | PHPUnit_Framework_MockObject_MockObject
     */
    private $mockFailedValidationResult;

    protected function setup()
    {
        $this->mockAppState = $this->getMockBuilder(StateDataService::class)->disableOriginalConstructor()->getMock();

        $this->mockPostRouter = $this->getMockBuilder(PostRouteChain::class)->disableOriginalConstructor()->getMock();

        $this->mockPostRequest = $this->getMockBuilder(PostRequest::class)->disableOriginalConstructor()->getMock();

        $this->mockProjectViewQuery = $this->getMockBuilder(ProjectViewQuery::class)
                                           ->disableOriginalConstructor()
                                           ->getMock();

        $this->mockFactory = $this->getMockBuilder(Factory::class)->disableOriginalConstructor()->getMock();

        $this->mockAppController = $this->getMockBuilder(ApplicationController::class)
                                        ->disableOriginalConstructor()
                                        ->getMock();

        $this->mockValidator = $this->getMockBuilder(CreateProjectValidator::class)
                                    ->disableOriginalConstructor()
                                    ->getMock();

        $this->mockSessionId = $this->getMockBuilder(SessionId::class)
                                    ->disableOriginalConstructor()
                                    ->getMock();

        $this->mockSuccessfulValidationResult = $this->getMockBuilder(SuccessfulValidationResult::class)
                                                     ->disableOriginalConstructor()
                                                     ->getMock();

        $this->mockFailedValidationResult = $this->getMockBuilder(FailedValidationResult::class)
                                                 ->disableOriginalConstructor()
                                                 ->getMock();

        $this->mockCreateProjectCommand = $this->getMockBuilder(CreateProjectCommand::class)
                                               ->disableOriginalConstructor()
                                               ->getMock();

        $this->mockRedirectResponse = $this->getMockBuilder(RedirectResponse::class)
                                           ->disableOriginalConstructor()
                                           ->getMock();

        $this->mockContentResponse = $this->getMockBuilder(ContentResponse::class)
                                          ->disableOriginalConstructor()
                                          ->getMock();

        $this->mockCreateProjectSuccessResult = $this->getMockBuilder(CreateProjectSuccessResult::class)
                                                     ->disableOriginalConstructor()
                                                     ->getMock();

        $this->getHandler = new PostRequestHandler(
            $this->mockFactory,
            $this->mockAppState,
            $this->mockPostRouter,
            $this->mockAppController
        );
    }

    public function testHandlerReturnsRedirectResponseOnSuccessfulValidation()
    {
        $this->mockFactory->method('createValidator')->willReturn($this->mockValidator);
        $this->mockValidator->method('validate')->willReturn($this->mockSuccessfulValidationResult);
        $this->mockAppController->method('handleCommandResult')->willReturn($this->mockRedirectResponse);
        $this->mockPostRouter->method('route')->willReturn($this->mockCreateProjectCommand);
        $this->mockSuccessfulValidationResult->method('isSuccess')->willReturn(true);
        $this->mockCreateProjectCommand->method('execute')->willReturn($this->mockCreateProjectSuccessResult);
        $this->mockAppState->method('getSessionId')->willReturn($this->mockSessionId);
        $this->mockRedirectResponse->method('setSessionId')->willReturn(null);

        $this->assertInstanceOf(RedirectResponse::class, $this->getHandler->handle($this->mockPostRequest));
    }

    public function testHandlerReturnsContentResponseOnFailedValidation()
    {
        $this->mockFactory->method('createValidator')->willReturn($this->mockValidator);
        $this->mockValidator->method('validate')->willReturn($this->mockFailedValidationResult);
        $this->mockAppController->method('handleValidationFailure')->willReturn($this->mockContentResponse);
        $this->mockPostRouter->method('route')->willReturn($this->mockCreateProjectCommand);
        $this->mockFailedValidationResult->method('isFailure')->willReturn(true);
        $this->mockCreateProjectCommand->method('execute')->willReturn($this->mockCreateProjectSuccessResult);
        $this->mockAppState->method('getSessionId')->willReturn($this->mockSessionId);
        $this->mockContentResponse->method('setSessionId')->willReturn(null);
        $this->mockAppController->method('handleCommandResult')->willReturn($this->mockContentResponse);

        $this->assertInstanceOf(ContentResponse::class, $this->getHandler->handle($this->mockPostRequest));
    }
}
