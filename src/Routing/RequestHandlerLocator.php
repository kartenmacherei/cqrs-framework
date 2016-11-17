<?php

namespace Kartenmacherei\HttpFramework\Routing;

use Kartenmacherei\HttpFramework\Request\Request;
use RuntimeException;

class RequestHandlerLocator
{
    /**
     * @var GetRequestHandler
     */
    private $getRequestHandler;

    /**
     * @var PostRequestHandler
     */
    private $postRequestHandler;

    /**
     * @param GetRequestHandler $getRequestHandler
     * @param PostRequestHandler $postRequestHandler
     */
    public function __construct(GetRequestHandler $getRequestHandler, PostRequestHandler $postRequestHandler)
    {
        $this->getRequestHandler = $getRequestHandler;
        $this->postRequestHandler = $postRequestHandler;
    }


    /**
     * @param Request $request
     * @return RequestHandler
     */
    public function locateHandler(Request $request) : RequestHandler
    {
        if ($request->isGetRequest()) {
            return $this->getRequestHandler;
        }
        elseif ($request->isPostRequest()) {
            return $this->postRequestHandler;
        }
        else {
            throw new RuntimeException('Cannot handle request');
        }
    }
}