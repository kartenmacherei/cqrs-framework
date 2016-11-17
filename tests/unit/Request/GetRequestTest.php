<?php
namespace Kartenmacherei\CQRSFramework\Http;

use Kartenmacherei\CQRSFramework\Library\NotFoundInCollectionException;
use Kartenmacherei\CQRSFramework\Library\RuntimeException;

/**
 * @uses   \Kartenmacherei\CQRSFramework\Http\Path
 * @uses   \Kartenmacherei\CQRSFramework\Http\ParameterCollection
 *
 * @uses   \Kartenmacherei\CQRSFramework\Http\GetRequest
 * @uses   \Kartenmacherei\CQRSFramework\Http\Request
 */
class GetRequestTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var getRequest
     */
    private $getRequest;

    public function setUp()
    {
        $path             = new Path('');
        $uriParameters    = new ParameterCollection();
        $cookieParameters = new ParameterCollection();
        $this->getRequest = new GetRequest($path, $uriParameters, $cookieParameters);
    }

    public function testCanBeCreatedFromSuperGlobals()
    {
        $_SERVER['REQUEST_METHOD'] = 'GET';
        $_SERVER['REQUEST_URI']    = '';
        $_COOKIE                   = [];
        $_GET                      = [];
        $instance                  = GetRequest::fromSuperGlobals();
        $this->assertInstanceOf(GetRequest::class, $instance);
    }

    public function testCannotCreateRequestWithInvalidRequestMethod()
    {
        $_SERVER['REQUEST_METHOD'] = 'Invalid Request Method';
        $_SERVER['REQUEST_URI']    = '';
        $_COOKIE                   = [];
        $_GET                      = [];

        $this->expectException(RuntimeException::class);

        GetRequest::fromSuperGlobals();
    }

    public function testReturnsTrueIfRequestIsTypeGet()
    {
        $isGetRequest = $this->getRequest->isGetRequest();
        $this->assertTrue($isGetRequest);
    }

    public function testReturnsFalseIfRequestIsTypePost()
    {
        $isPostRequest = $this->getRequest->isPostRequest();
        $this->assertFalse($isPostRequest);
    }

    public function testReturnsTrueIfRequestPathIsValid()
    {
        $path = $this->getRequest->getPath();
        $this->assertInstanceOf(Path::class, $path);
    }

    public function testCanNotGetInvalidParameterValue()
    {
        $this->expectException(NotFoundInCollectionException::class);
        $this->getRequest->getParameterByName("SomeName");
    }

    public function testRequestDoesNotHaveGivenParameter()
    {
        $this->assertFalse($this->getRequest->hasParameter("SomeName"));
    }

    public function testCanGetCookie()
    {
        $this->expectException(NotFoundInCollectionException::class);
        $this->getRequest->getCookieByName("SomeName");
    }

    public function testRequestDoesNotHaveGivenCookieValue()
    {
        $this->assertFalse($this->getRequest->hasCookie("SomeName"));
    }

    public function testSessionIdCanBeRetrieved()
    {
        $sessionId = $this->getRequest->getSessionId();

        $this->assertEquals($sessionId, $this->getRequest->getSessionId());
    }

    public function testSessionIdIsSetOnRetrievalIfNotAlreadySet()
    {
        $this->assertInstanceOf(SessionId::class, $this->getRequest->getSessionId());
    }
}
