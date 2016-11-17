<?php

namespace Kartenmacherei\HttpFramework\Routing;

use Kartenmacherei\HttpFramework\Request\Request;
use Kartenmacherei\HttpFramework\Response\Response;

interface RequestHandler
{
    /**
     * @param Request $request
     * @return Response
     */
    public function handle(Request $request) : Response;
}