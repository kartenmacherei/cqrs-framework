<?php

namespace Kartenmacherei\HttpFramework\Http;

use \Kartenmacherei\HttpFramework\Library\RuntimeException;

/**
 * @uses     \Kartenmacherei\HttpFramework\Http\Path
 * @uses     \Kartenmacherei\HttpFramework\Http\ParameterCollection
 *
 * @covers   \Kartenmacherei\HttpFramework\Http\Request
 * @covers   \Kartenmacherei\HttpFramework\Http\PostRequest
 */
class PostRequestTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var PostRequest
     */
    protected $postRequest;

    protected function setUp()
    {
        $this->postRequest = new PostRequest(new Path(''), new ParameterCollection(), new ParameterCollection());
    }

    public function testReturnsTrueIfRequestIsPost()
    {
        $this->assertTrue($this->postRequest->isPostRequest());
    }

    public function testReturnsFalseIfRequestIsGet()
    {
        $this->assertFalse($this->postRequest->isGetRequest());
    }

    public function testPostRequestCanBeCreatedFromSuperGlobals()
    {

        $_SERVER['REQUEST_METHOD'] = 'POST';
        $_SERVER['REQUEST_URI']    = "";
        $_COOKIE                   = [];
        $_POST                     = [];
        $instance                  = PostRequest::fromSuperGlobals();
        $this->assertInstanceOf(PostRequest::class, $instance);
    }

    public function testCannotCreateRequestWithInvalidRequestMethod()
    {

        $_SERVER['REQUEST_METHOD'] = 'Invalid Request Method';
        $_SERVER['REQUEST_URI']    = "";
        $_COOKIE                   = [];
        $_GET                      = [];

        $this->expectException(RuntimeException::class);

        PostRequest::fromSuperGlobals();
    }

    public function testReturnsTrueIfRequestIsTypePost()
    {
        $isPostRequest = $this->postRequest->isPostRequest();
        $this->assertTrue($isPostRequest);
    }

    public function testReturnsFalseIfRequestIsTypeGet()
    {

        $isGetRequest = $this->postRequest->isGetRequest();
        $this->assertFalse($isGetRequest);
    }
}
